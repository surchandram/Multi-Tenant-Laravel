<?php

namespace SAAS\Domain\Companies\Models;

use Laravel\Cashier\Subscription;

class CompanySubscription extends Subscription
{
    /**
     * Get the model related to the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Company::class, (new Company)->getForeignKey());
    }

    /**
     * Get the subscription items related to the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CompanySubscriptionItem::class, 'subscription_id');
    }
}
