<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;

class ProjectAffectedArea extends Model
{
    use ForTenants;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'project_id',
        'affected_area_id',
    ];

    /**
     * Get the model related to the affected area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affectedArea()
    {
        return $this->belongsTo(AffectedArea::class);
    }

    /**
     * Get the project associated to the affected area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
