<?php

namespace SAAS\Domain\Notices\Models;

use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\IsTenant;
use Miracuthbert\Multitenancy\Models\Tenant;

class Notice extends Model implements Tenant
{
    use IsTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'domain',
    ];

    //
}
