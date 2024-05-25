<?php

namespace SAAS\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;

class UserInvitationPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UserInvitation $userInvitation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Users\Models\UserInvitation  $userInvitation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UserInvitation $userInvitation)
    {
        //
    }
}
