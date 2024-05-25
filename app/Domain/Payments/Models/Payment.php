<?php

namespace SAAS\Domain\Payments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SAAS\Domain\Payments\Builders\PaymentBuilder;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway',
        'gateway_id',
        'subtotal',
        'tax',
        'total',
    ];

    public function payable()
    {
        return $this->morphTo();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new PaymentBuilder($query);
    }
}
