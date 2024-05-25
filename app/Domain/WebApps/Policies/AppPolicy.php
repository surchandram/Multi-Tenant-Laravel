<?php

namespace SAAS\Domain\WebApps\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\WebApps\Models\App;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('browse apps');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, App $app)
    {
        return $user->can('browse apps');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create and edit apps');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, App $app)
    {
        return $user->can('create and edit apps');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, App $app)
    {
        return $user->can('create and edit apps');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, App $app)
    {
        return $user->can('delete and restore apps');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, App $app)
    {
        return $user->can('delete and restore apps');
    }
}
