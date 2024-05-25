<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Devices\Models\Device;

class PsychrometryDeviceMap extends Model
{
    use ForTenants;
    use HasFactory;

    protected $fillable = [
        'device_id',
        'project_id',
        'project_affected_area_id',
        'psychrometry_measure_point_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function affectedArea()
    {
        return $this->belongsTo(ProjectAffectedArea::class);
    }

    public function psychrometryMeasurePoint()
    {
        return $this->belongsTo(PsychrometryMeasurePoint::class);
    }
}
