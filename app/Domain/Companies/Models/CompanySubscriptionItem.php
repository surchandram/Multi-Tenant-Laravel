<?php

namespace SAAS\Domain\Companies\Models;

use Laravel\Cashier\SubscriptionItem;

class CompanySubscriptionItem extends SubscriptionItem
{
    protected $table = 'company_subscription_items';

    /**
     * Get the subscription that the item belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(CompanySubscription::class, 'subscription_id');
    }
}
