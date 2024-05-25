<?php

namespace SAAS\App\Support\Traits\Eloquent;

use Illuminate\Support\Arr;
use SAAS\Domain\Addresses\Models\Address;

trait CanOwnAddress
{
    /**
     * Boot `CanOwnAddress` trait.
     */
    public static function bootCanOwnAddress()
    {
        //
    }

    /**
     * Get the model's billing address.
     *
     * @return null|\SAAS\Domain\Addresses\Models\Address
     */
    public function getBillingAddress()
    {
        if (! $this->hasBillingAddress()) {
            return $this->getDefaultAddress();
        }

        return $this->addresses->where('billing', true)->first();
    }

    /**
     * Determine if model has a billing address.
     *
     * @return bool
     */
    public function hasBillingAddress()
    {
        return $this->addresses->where('billing', true)->count();
    }

    /**
     * Get the model's default address.
     *
     * @return null|\SAAS\Domain\Addresses\Models\Address
     */
    public function getDefaultAddress()
    {
        return $this->addresses->where('default', true)->first();
    }

    /**
     * Determine if model has a default address.
     *
     * @return bool
     */
    public function hasDefaultAddress()
    {
        return $this->addresses->where('default', true)->count();
    }

    /**
     * Create a new address for entity.
     *
     * @param  array  $data The details of the address
     * @return bool|\SAAS\Domain\Addresses\Models\Address
     */
    public function addAddress($data)
    {
        $address = new Address(Arr::only($data, [
            'name',
            'address_1',
            'address_2',
            'state',
            'city',
            'postal_code',
            'default',
            'billing',
            'country_id',
        ]));

        return $this->addresses()->save($address);
    }

    /**
     * Create or update address for entity.
     *
     * @param  array  $data The details of the address
     * @param  int|null  $id The existing addresses address
     * @return \SAAS\Domain\Addresses\Models\Address
     */
    public function addOrUpdateAddress($data, $id = null)
    {
        $address = $this->addresses()->updateOrCreate([
            'id' => $id,
        ], Arr::only($data, [
            'name',
            'address_1',
            'address_2',
            'state',
            'city',
            'postal_code',
            'default',
            'billing',
            'country_id',
        ]));

        return $address;
    }

    /**
     * Get the model's address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get all of the model's addresses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
