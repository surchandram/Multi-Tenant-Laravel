<?php

namespace SAAS\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Users\Models\User;

class Thread extends Model
{
    use ForTenants;
    use HasFactory;
    use NodeTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Get the parent threadable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function threadable()
    {
        return $this->morphTo();
    }

    /**
     * Get all the messages posted on this thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id', 'id');
    }

    /**
     * Get all the messages posted on this thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->getConnection()->getDatabaseName().'.thread_user');
    }
}
