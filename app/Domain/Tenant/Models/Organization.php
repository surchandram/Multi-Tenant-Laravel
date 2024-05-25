<?php

namespace SAAS\Domain\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\CanOwnAddress;

class Organization extends Model
{
    use ForTenants;
    use HasFactory;
    use CanOwnAddress;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'organization_type_id',
    ];

    /**
     * Get all users related to the organization.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(OrganizationUser::class);
    }

    /**
     * Get the organization type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id');
    }
}
