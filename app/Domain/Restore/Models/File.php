<?php

namespace SAAS\Domain\Restore\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Users\Models\User;

class File extends Model
{
    use ForTenants, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
    ];

    /**
     * Get project that owns the file.
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get user that owns file.
     *
     * Undocumented function long description
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
