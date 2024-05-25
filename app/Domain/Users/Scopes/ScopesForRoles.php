<?php

namespace SAAS\Domain\Users\Scopes;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use SAAS\Domain\Users\ValueObjects\RoleType;

trait ScopesForRoles
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootScopesForRoles()
    {
        //
    }

    /**
     * Scope query to include only "valid" roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  string  $class
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyForType(Builder $builder, string $class)
    {
        if (! ($type = RoleType::from($class)->type)) {
            throw new Exception(
                "Class [$class] does not have a matching role type."
            );
        }

        return $builder->where('type', $type);
    }

    /**
     * Scope query to include only "valid" roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyValidRoles(Builder $builder)
    {
        return $builder->active()
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
    }
}
