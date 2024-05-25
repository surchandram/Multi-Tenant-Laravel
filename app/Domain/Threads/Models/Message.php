<?php

namespace SAAS\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\Domain\Users\Models\User;

class Message extends Model
{
    use ForTenants;
    use HasFactory;
    use NodeTrait;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'thread_messages';

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'thread',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body',
        'user_id',
        'thread_id',
        'edited_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'edited_at' => 'datetime',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function booting()
    {
        static::updating(function ($model) {
            $model->edited_at = now();
        });
    }

    /**
     * Get thread that owns message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get user that posted message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
