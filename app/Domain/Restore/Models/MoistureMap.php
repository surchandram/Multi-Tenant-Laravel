<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Devices\Models\Device;

class MoistureMap extends Model
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
        'project_affected_area_id',
        'structure_id',
        'material_id',
        'device_id',
    ];

    /**
     * Get the device associated to the mapped area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Get all the readings for the moisture map.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readings()
    {
        return $this->hasMany(MoistureMapReading::class, 'moisture_map_id', 'id')->orderBy('recorded_at', 'asc');
    }

    /**
     * Get the material associated to the affected area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the structure associated to the affected area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    /**
     * Get the model related to the affected area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affectedArea()
    {
        return $this->belongsTo(ProjectAffectedArea::class, 'project_affected_area_id', 'id');
    }

    /**
     * Get the project that owns the moisture map.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
