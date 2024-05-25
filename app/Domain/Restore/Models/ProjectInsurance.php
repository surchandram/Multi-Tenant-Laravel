<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Money;
use SAAS\Domain\Tenant\Models\Organization;
use SAAS\Domain\Tenant\Models\Person;

/**
 * @property float $deductible
 */
class ProjectInsurance extends Model
{
    use HasFactory;
    use ForTenants;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_insurance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'organization_id',
        'agent_id',
        'adjuster_id',
        'claim_no',
        'policy_no',
        'deductible',
    ];

    /**
     * Get and return deductible as instance of Money.
     *
     * @return \SAAS\App\Support\Money
     */
    public function getDeductibleAttribute($value)
    {
        return new Money($value);
    }

    /**
     * Get the insurance's adjuster for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adjuster()
    {
        return $this->belongsTo(Person::class, 'adjuster_id', 'id');
    }

    /**
     * Get the insurance agent for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent()
    {
        return $this->belongsTo(Person::class, 'agent_id', 'id');
    }

    /**
     * Get the insurance company for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    /**
     * Get the project covered by the insurance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
