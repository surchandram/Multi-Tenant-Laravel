<?php

namespace SAAS\Domain\Users\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /**
     * Instance of User.
     *
     * @var Model
     */
    protected $user;

    /**
     * SingleTenantScope constructor.
     *
     * @param  $user
     * @return void
     */
    public function __construct(Model $user)
    {
        $this->user = $user;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where($this->user->getForeignKey(), '=', $this->user->id);
    }
}
