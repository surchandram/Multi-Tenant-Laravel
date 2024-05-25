<?php

namespace SAAS\Domain\Projects\Models;

use SAAS\Domain\Files\Models\File;
use Illuminate\Database\Eloquent\Model;
use SAAS\App\Support\Traits\Eloquent\UserOwnedTrait;

class Project extends Model
{
    use UserOwnedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get project files.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
