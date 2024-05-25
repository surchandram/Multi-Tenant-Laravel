<?php

namespace SAAS\Domain\Addresses\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\CanBeDefault;
use SAAS\Domain\Countries\Models\Country;

class Address extends Model
{
    use CanBeDefault;
    use ForTenants;
    use HasFactory;

    public $overrideDefaults = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'address_1',
        'address_2',
        'state',
        'city',
        'postal_code',
        'default',
        'billing',
        'country_id',
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    public static function booting()
    {
        static::creating(function ($model) {
            $model->changeDefaultsForModel();
        });

        static::updating(function ($model) {
            $model->changeDefaultsForModel();
        });
    }

    /**
     * Get a formatted address.
     */
    public function formattedAddress(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf(
                '%s, %s, %s, %s',
                $this->address_1,
                $this->city,
                $this->state,
                $this->postal_code,
            )
        );
    }

    /**
     * Sets the 'billing' attribute correct value.
     *
     * @return void
     */
    public function setBillingAttribute($value)
    {
        $this->attributes['billing'] = ($value === 'true' || $value ? true : false);
    }

    /**
     * Change the owning model's existing 'default' addresses to 'false'.
     *
     * @return void
     */
    public function changeDefaultsForModel()
    {
        $data = [];

        if ($this->default === true) {
            $data = array_merge($data, [
                'default' => false,
            ]);
        }

        if ($this->billing === true) {
            $data = array_merge($data, [
                'billing' => false,
            ]);
        }

        if (count($data) < 1) {
            return;
        }

        $this->addressable->addresses()->update($data);
    }

    /**
     * Determine if address is set as default for billing.
     *
     * @return bool
     */
    public function forBilling()
    {
        return $this->billing;
    }

    /**
     * Get the owning addressable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Get the country that owns the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
