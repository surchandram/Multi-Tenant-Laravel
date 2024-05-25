<?php

namespace SAAS\Domain\Companies\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Miracuthbert\LaravelRoles\Models\Role;
use Miracuthbert\LaravelRoles\Models\Traits\CanUseRoles;
use Miracuthbert\Multitenancy\Models\Tenant;
use Miracuthbert\Multitenancy\Traits\ForSystem;
use Miracuthbert\Multitenancy\Traits\IsTenant;
use SAAS\App\Subscriptions\HasSubscriptions;
use SAAS\App\Support\Roles;
use SAAS\App\Support\Traits\Eloquent\CanAssignRoles;
use SAAS\App\Support\Traits\Eloquent\CanOwnAddress;
use SAAS\App\Support\Traits\Eloquent\HasLogo;
use SAAS\Domain\Companies\Actions\CreateCompanyStripeAccountAction;
use SAAS\Domain\Companies\Builders\CompanyBuilder;
use SAAS\Domain\Companies\Collections\CompanyCollection;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\Teams\Traits\CanOwnTeam;
use SAAS\Domain\Users\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia, Tenant
{
    use Billable,
        CanAssignRoles,
        CanOwnAddress,
        CanOwnTeam,
        CanUseRoles,
        ForSystem,
        HasFactory,
        HasLogo,
        HasSubscriptions,
        InteractsWithMedia,
        IsTenant,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'uuid',
        'domain',
        'email',
        'user_id',
        'personal_team',
        'measurement_unit',
        'currency',
        'default_tax',
        'license_no',
        'tax_id',
        'projects_prefix',
        'data',
        'stripe_account_id',
        'stripe_account_enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'stripe_account_enabled' => 'bool',
    ];

    /**
     * Get or create a stripe account for the company if it does not exist.
     */
    public function ensureStripeConnectAccountCreated(): string
    {
        if ($this->stripe_account_id) {
            return $this->stripe_account_id;
        }

        $response = CreateCompanyStripeAccountAction::execute($this);

        return $response->id;
    }

    /**
     * Get the date until domain is allowed to be changed.
     */
    public function getDateDomainIsUnlocked(): string
    {
        return now()->addDays(config('saas.company_domain_change_lock', 60) - $this->getDomainChangeInDaysFromToday())->toFormattedDateString();
    }

    /**
     * Get the difference in days since domain was changed.
     */
    public function getDomainChangeInDaysFromToday(): int
    {
        if (is_null($this->data)) {
            return config('saas.company_domain_change_lock', 60);
        }

        return now()->diffInDays($this->data['domain_updated_at']);
    }

    /**
     * Get default address.
     */
    public function address(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->addresses->where('default', true)->first(),
        );
    }

    /**
     * Flush team cache.
     */
    public function flushCache()
    {
        Cache::forget($this->planCacheKey());
        Cache::forget('company_role_count_'.Str::slug($this->teamAdminRoleSlug(), '_'));
    }

    /**
     * Get team's plan cache key.
     */
    protected function planCacheKey(): string
    {
        return 'company_plan_'.$this->id;
    }

    /**
     * Get the team's current plan.
     *
     * @return mixed
     */
    public function getPlanAttribute()
    {
        $plan = Cache::remember($this->planCacheKey(), 3600, function () {
            return $this->plans()->with([
                'features.feature',
            ])->first();
        });

        return $plan;
    }

    /**
     * Determine if the team has reached the plan limit.
     *
     * @param  string  $featureKey
     * @param  bool  $relation
     * @return bool
     */
    public function hasReachedPlanLimit($featureKey = 'users', $relation = true)
    {
        if ($this->hasNoSubscription()) {
            return true;
        }

        $feature = $this->plan->feature($featureKey);

        if (! $feature) {
            return true;
        }

        $limit = optional($feature)->limit;

        if ($limit == null) {
            return false;
        }

        $count = $relation ? optional($this->{$featureKey})->count() : optional($this->{$featureKey});

        return $count >= $limit;
    }

    /**
     * Determine if the team can downgrade to a plan.
     *
     * @return bool
     */
    public function canDowngrade(Plan $plan)
    {
        if (! $this->plan) {
            return false;
        }

        $users = $this->users->count();

        if (! $users) {
            return false;
        }

        $planUsers = $plan->feature('users');

        return $users <= optional($planUsers)->limit;
    }

    /**
     * Get the slug for team 'Admin' role.
     *
     * @return string
     */
    public function teamAdminRoleSlug()
    {
        return Roles::$roleWhenCreatingCompany;
    }

    /**
     * Check if current user owns the team.
     *
     * @return mixed
     */
    public function ownedByCurrentUser()
    {
        return $this->ownedBy(auth()->user());
    }

    /**
     * Check if user is the admin or owner of the team.
     *
     * @return mixed
     */
    public function ownedBy(User $user)
    {
        return $this->users->find($user)->hasRole(
            Str::slug(Roles::$roleWhenCreatingCompany),
            $this
        );
    }

    public function allRoles()
    {
        $teamAdmin = Role::whereSlug(Roles::$roleWhenCreatingCompany)->with([
            'users' => function ($query) {
                $query->where('permitable_id', $this->getKey())->whereNull('expires_at')->orWhere('expires_at', '>', now());
            },
        ])->first();
        $this->roles->prepend($teamAdmin);

        return $this;
    }

    /**
     * Get the apps used by the company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(CompanyApp::class);
    }

    /**
     * Get the plans company has subscribed to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function plans()
    {
        return $this->hasManyThrough(
            Plan::class,
            CompanySubscription::class,
            'company_id',
            'provider_id',
            'id',
            'stripe_price'
        )->with('features')->orderBy('company_subscriptions.created_at', 'desc');
    }

    /**
     * Get all of the subscriptions for the Stripe model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(CompanySubscription::class, $this->getForeignKey())
            ->orderBy('created_at', 'desc');
    }

    /**
     * The user that owns the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The users that are in the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new CompanyCollection($models);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new CompanyBuilder($query);
    }
}
