<?php

namespace SAAS\App\Support\Traits\Eloquent;

use SAAS\Domain\Users\Observers\UserRelationshipObserver;
use SAAS\Domain\Users\Scopes\UserScope;
use SAAS\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait UserOwnedTrait
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootUserOwnedTrait()
    {
        static::addGlobalScope(
            new UserScope(auth()->user())
        );

        static::observe(
            UserRelationshipObserver::class
        );
    }

    /**
     * Scope query to exclude "UserScope".
     *
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutUser(Builder $builder)
    {
        return $builder->withoutGlobalScope(UserScope::class);
    }

    /**
     * Get the user that owns the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
