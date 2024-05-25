<?php

namespace SAAS\Domain\Restore\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\CanOwnAddress;
use SAAS\Domain\Documents\Traits\InteractsWithDocuments;
use SAAS\Domain\Restore\Builders\ProjectBuilder;
use SAAS\Domain\Restore\Enums\ProjectStatuses as ProjectStatusEnum;
use SAAS\Domain\Restore\Filters\ProjectFilters;
use SAAS\Domain\Teams\Models\Team;
use SAAS\Domain\Tenant\Models\Person;
use SAAS\Domain\Threads\Concerns\HasThread;
use SAAS\Domain\Threads\Contracts\Threadable;
use SAAS\Domain\Users\Models\User;

class Project extends Model implements Threadable
{
    use CanOwnAddress;
    use ForTenants;
    use HasFactory;
    use HasThread;
    use InteractsWithDocuments;
    use Sluggable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'slug',
        'description',
        'overview',
        'type_id',
        'class_id',
        'category_id',
        'status_id',
        'point_of_loss',
        'loss_occurred_at',
        'contacted_at',
        'starts_at',
        'ends_at',
        'owner_id',
        'team_id',
        'user_id',
    ];

    protected $casts = [
        'loss_occurred_at' => 'date',
        'contacted_at' => 'date',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function booting()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();

            $model->status_id = ProjectStatus::findBySlug(
                ProjectStatusEnum::Draft->value
            )?->id;
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function canBeChanged(): bool
    {
        return $this->currentStatus->createProjectStatus($this)->canBeChanged();
    }

    public function currentStatus(): Attribute
    {
        return new Attribute(
            fn () => ProjectStatusEnum::tryFrom($this->status->slug),
        );
    }

    /**
     * Determine if project can be approved for completion.
     *
     * @return bool
     */
    public function canApproveCompletion()
    {
        return $this->project->status->slug == ProjectStatusEnum::ApproveCompletion->value;
    }

    /**
     * Determine if project can be authorized to start.
     *
     * @return bool
     */
    public function canAuthorizeStart()
    {
        return $this->project->status->slug == ProjectStatusEnum::Pending->value;
    }

    /**
     * Get all the logs posted for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(ProjectLog::class, 'project_id', 'id');
    }

    /**
     * Get the user associated with project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get all the psychrometric reports defined for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function psychrometricReports()
    {
        return $this->hasMany(PsychrometryReport::class, 'project_id', 'id');
    }

    /**
     * Get all the sensors setup for project's psychrometric report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function psychrometricReportDevices()
    {
        return $this->hasMany(PsychrometryDeviceMap::class, 'project_id', 'id');
    }

    /**
     * Get all the moisture maps defined in the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moistureMap()
    {
        return $this->hasMany(MoistureMap::class, 'project_id', 'id');
    }

    /**
     * Get all the affected areas defined in the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function affectedAreas()
    {
        return $this->hasMany(ProjectAffectedArea::class, 'project_id', 'id');
    }

    /**
     * Get the team assigned to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    /**
     * Get the project property owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Person::class, 'owner_id', 'id');
    }

    /**
     * Get the project's insurance claim.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function insurance()
    {
        return $this->hasOne(ProjectInsurance::class);
    }

    /**
     * Get the project's status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    /**
     * Get the type that the project belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProjectType::class);
    }

    /**
     * Get the class that the project belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function class()
    {
        return $this->belongsTo(ProjectClass::class);
    }

    /**
     * Get the category that the project belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    /**
     * Get project files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new ProjectBuilder($query);
    }

    /**
     * Scope a query to include only "records" that match passed filters.
     */
    public function scopeFilter(Builder $builder, $request, array $filters = []): Builder
    {
        return (new ProjectFilters($request))->add($filters)->filter($builder);
    }
}
