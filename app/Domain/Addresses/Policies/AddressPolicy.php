<?php

namespace SAAS\Domain\Addresses\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use SAAS\Domain\Addresses\Models\Address;
use SAAS\Domain\Users\Models\User;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function view(User $user, Address $address)
    {
        return $this->touch($user, $address);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function update(User $user, Address $address)
    {
        return $this->touch($user, $address);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function delete(User $user, Address $address)
    {
        return $this->touch($user, $address);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function restore(User $user, Address $address)
    {
        return $this->touch($user, $address);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function forceDelete(User $user, Address $address)
    {
        return $this->touch($user, $address);
    }

    /**
     * Determine whether the user can perform any action on the model.
     *
     * @param  \SAAS\Domain\Users\Models\User  $user
     * @param  \SAAS\Domain\Addresses\Models\Address  $address
     * @return mixed
     */
    public function touch($user, $address)
    {
        return $user->id === $address->user_id;
    }
}
