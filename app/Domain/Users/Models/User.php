<?php

namespace SAAS\Domain\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Miracuthbert\LaravelRoles\Models\Traits\LaravelRolesUserTrait;
use SAAS\App\Subscriptions\HasSubscriptions;
use SAAS\App\Support\Traits\Eloquent\CanOwnAddress;
use SAAS\App\Support\Traits\Eloquent\HasAvatar;
use SAAS\App\Support\Traits\Eloquent\IsAssignedRoles;
use SAAS\App\TwoFactor\HasTwoFactorAuthentication;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Plans\Models\Plan;
use SAAS\Domain\SocialAccount\Models\SocialAccount;
use SAAS\Domain\Users\Builders\UserBuilder;
use SAAS\Domain\Users\Filters\UserFilters;
use Saasplayground\SupportTickets\Traits\Eloquent\InteractsWithTickets;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Billable,
        CanOwnAddress,
        HasApiTokens,
        HasAvatar,
        HasFactory,
        HasSubscriptions,
        HasTwoFactorAuthentication,
        InteractsWithMedia,
        InteractsWithTickets,
        IsAssignedRoles,
        LaravelRolesUserTrait,
        Notifiable,
        SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that should be appended to the model.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'email_verified_at',
        'current_team_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'domain.users.'.$this->id;
    }

    /**
     * Register the conversions that should be performed.
     *
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        //
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl($this->avatarFallbackUrl($this->name))
            ->singleFile();
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return env('DB_CONNECTION');
    }

    /**
     * Determine if user has personal team.
     *
     * @return bool
     */
    public function getHasPersonalTeamAttribute()
    {
        $class = Company::class;

        return $this->personalTeam() instanceof $class;
    }

    /**
     * Get user's personal team.
     *
     * @return null|\SAAS\Domain\Companies\Models\Company
     */
    public function personalTeam()
    {
        return $this->companies->where('personal_team', true)->first();
    }

    /**
     * Determine if the user is the last team admin.
     *
     * @param  \SAAS\Domain\Companies\Models\Company  $team
     * @return bool
     */
    public function isOnlyAdminInCompany(Company $company)
    {
        $company_admin = $company->teamAdminRoleSlug();

        $cacheKey = 'company_role_count_'.Str::slug($company_admin, '_');

        $count = $company->users()->whereRoleIs($company_admin)->count();

        return $this->hasRole($company_admin, $company) && $count == 1;
    }

    /**
     * Determine if the user can downgrade to a plan.
     *
     * @return bool
     */
    public function canDowngrade(Plan $plan)
    {
        if (! $this->plan) {
            return false;
        }

        // replace lines below with a condition to check against the passed plan
        // eg. $this->groups->count() || $this->venues->count()
        return true;
    }

    /**
     * Get the user's avatar.
     *
     * @param  int  $size
     * @return string
     */
    public function avatar($size = 45)
    {
        return 'https://www.gravatar.com/avatar/'.md5($this->email).'?s='.$size.'&d=mm';
    }

    /**
     * Filters the result.
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new UserFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Get user's full name as attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if current user matches passed user.
     *
     * @return bool
     */
    public function isTheSameAs(User $user)
    {
        return $this->id === $user->id;
    }

    /**
     * Get plan that the user is currently on.
     *
     * @return mixed
     */
    public function plan()
    {
        return $this->plans->first();
    }

    /**
     * Get user's plan as a property.
     *
     * @return mixed
     */
    public function getPlanAttribute()
    {
        return $this->plan();
    }

    /**
     * Get plans owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function plans()
    {
        return $this->hasManyThrough(
            Plan::class,
            Subscription::class,
            'user_id',
            'provider_id',
            'id',
            'stripe_price'
        )->orderBy('subscriptions.created_at', 'desc');
    }

    /**
     * Get companies that user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * Get roles assigned to the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->using(UserRole::class)
            ->withTimestamps()
            ->withPivot(['expires_at', 'permitable_id']);
    }

    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new UserBuilder($query);
    }
}
