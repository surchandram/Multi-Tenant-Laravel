<?php

namespace SAAS\Domain\Users\Models;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use SAAS\Domain\Users\Events\SendUserInvitation;

class UserInvitation extends Model
{
    use HasFactory,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'name',
        'email',
        'type',
        'message',
        'accepted_at',
        'rejected_at',
        'expires_at',
        'role_id',
        'role_expires_at',
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'expires_at' => 'datetime',
        'role_expires_at' => 'datetime',
        'data' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => SendUserInvitation::class,
    ];

    /**
     * Perform any actions required before the model boots.
     *
     * @return void
     */
    public static function booting()
    {
        static::creating(function ($invitation) {
            $invitation->identifier = uniqid();

            if (! $invitation->expires_at) {
                $invitation->expires_at = $invitation->role_expires_at ?? config('saas.invitations.expires');
            }

            if (! $invitation->type) {
                $role = is_numeric($invitation->role_id) ? Role::find($invitation->role_id) : null;

                $invitation->type = $role ? $role->type : config('saas.invitations.default', 'referral');
            }
        });
    }

    /**
     * Determine if invitation has a custom mail class based on its type.
     */
    public function hasCustomMailClass(): bool
    {
        return Arr::has(config('saas.invitations.mails', []), $this->type);
    }

    /**
     * Resolve and instanciate mail class for invitation.
     */
    public function resolvedMailClass(): Mailable
    {
        $class = Arr::get(config('saas.invitations.mails', []), $this->type);

        return new $class($this);
    }

    /**
     * Determine if invitation has expired.
     *
     * @return bool
     */
    public function hasExpired()
    {
        if (filled($this->rejected_at) || filled($this->accepted_at)) {
            return true;
        }

        return filled($this->expires_at) && $this->expires_at->lt(now());
    }

    /**
     * Revoke invitation by setting 'expire' timestamps.
     *
     * @return bool
     */
    public function revoke()
    {
        return $this->update([
            'expires_at' => $timestamp = now(),
            'role_expires_at' => $timestamp,
        ]);
    }

    /**
     * Mark invitation as accepted.
     *
     * @return bool
     */
    public function markAccepted()
    {
        return $this->update([
            'accepted_at' => $timestamp = now(),
            'expires_at' => $timestamp,
        ]);
    }

    /**
     * Resolve and return the invitation's status.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        if (! empty($this->accepted_at)) {
            return 'accepted';
        }

        if (! empty($this->rejected_at)) {
            return 'rejected';
        }

        if (! empty($this->expires_at)) {
            return 'expired';
        }

        return 'pending';
    }

    /**
     * Filter query to only include 'accepted' invitations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsAccepted(Builder $builder)
    {
        return $builder->where([
            ['accepted_at', '!=', null],
            ['rejected_at', '=', null],
        ])->whereNotNull('expires_at');
    }

    /**
     * Filter query results to only match 'pending' invitations
     * if passed value is true.
     *
     * @param  bool  $pending
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsStillValid(Builder $builder, $pending = true)
    {
        if (! $pending) {
            return $builder;
        }

        return $builder->where([
            ['accepted_at', '=', null],
            ['rejected_at', '=', null],
        ])->where(function ($query) {
            $query->whereNull('expires_at')->orWhere('expires_at', '>', now()->addMinutes(5));
        });
    }

    /**
     * Get the roleable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function roleable()
    {
        return $this->morphTo();
    }

    /**
     * Get the referable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function referable()
    {
        return $this->morphTo();
    }

    /**
     * Get the role attached to the invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
