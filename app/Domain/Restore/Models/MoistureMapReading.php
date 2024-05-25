<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;

class MoistureMapReading extends Model
{
    use ForTenants;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'moisture_map_id',
        'value',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the moisture map that owns the reading.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moistureMap()
    {
        return $this->hasMany(MoistureMap::class, 'moisture_map_id', 'id');
    }
}
