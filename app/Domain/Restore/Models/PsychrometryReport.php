<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Restore\Collections\PsychrometryReportCollection;

class PsychrometryReport extends Model
{
    use ForTenants;
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_affected_area_id',
        'psychrometry_measure_point_id',
        'temperature',
        'relative_humidity',
        'recorded_at',
    ];

    protected $appends = [
        'grain_per_pound',
        'dew_point',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function getDewPointAttribute()
    {
        $relativeHumidity = $this->relative_humidity;
        $dryBulbTempF = $this->temperature;

        if (empty($relativeHumidity)) {
            return null;
        }

        // Convert temperature to Celsius
        $dryBulbTempC = ($dryBulbTempF - 32) * 5 / 9;

        // Calculate saturation vapor pressure (hPa)
        $saturationVaporPressure = 6.112 * exp((17.67 * $dryBulbTempC) / ($dryBulbTempC + 243.5));

        // Calculate actual vapor pressure (hPa)
        $actualVaporPressure = ($relativeHumidity / 100) * $saturationVaporPressure;

        // Calculate dew point (°F)
        $dewPointC = (243.5 * log($actualVaporPressure / 6.112)) / (17.67 - log($actualVaporPressure / 6.112));

        $dewPointF = ($dewPointC * 9 / 5) + 32;

        return round($dewPointF);
    }

    public function getGrainPerPoundAttribute()
    {
        $relativeHumidity = $this->relative_humidity;
        $dryBulbTempF = $this->temperature;

        if (empty($relativeHumidity)) {
            return null;
        }

        // Constants for mixing ratio calculation
        $epsilon = 0.622;
        $pwsConstant = 6.112;
        $tZero = 273.15;

        // Convert temperature to Celsius
        $dryBulbTempC = ($dryBulbTempF - 32) * 5 / 9;

        // Calculate saturation vapor pressure (hPa)
        $saturationVaporPressure = $pwsConstant * exp((17.67 * $dryBulbTempC) / ($dryBulbTempC + 243.5));

        // Calculate actual vapor pressure (hPa)
        $actualVaporPressure = ($relativeHumidity / 100) * $saturationVaporPressure;

        // Calculate mixing ratio (g/kg)
        $mixingRatioGPK = ($epsilon * $actualVaporPressure) / (1013.25 - $actualVaporPressure);

        // Convert mixing ratio to grains per pound (gpp)
        $mixingRatioGPP = $mixingRatioGPK * 7000;

        return round($mixingRatioGPP, 0); // Round decimal place
    }

    /**
     * Get the measure point for the report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function psychrometryMeasurePoint()
    {
        return $this->belongsTo(PsychrometryMeasurePoint::class, 'psychrometry_measure_point_id', 'id');
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

    /**
     * Create a new Eloquent Collection instance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new PsychrometryReportCollection($models);
    }
}
