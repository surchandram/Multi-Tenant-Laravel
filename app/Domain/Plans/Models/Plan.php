<?php

namespace SAAS\Domain\Plans\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use SAAS\App\Support\Traits\Eloquent\HasPrice;
use SAAS\App\Support\Traits\Eloquent\IsUsable;
use SAAS\Domain\Companies\Models\CompanySubscription;
use SAAS\Domain\Features\Models\Feature;

class Plan extends Model
{
    use HasPrice,
        IsUsable,
        SoftDeletes;

    /**
     * Plan intervals.
     *
     * @var array
     */
    public static $intervals = [
        'day' => 'Daily',
        'week' => 'Weekly',
        'month' => 'Monthly',
        'year' => 'Yearly',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'interval',
        'description',
        'provider_id',
        'price',
        'teams',
        'per_seat',
        'usable',
        'synced_to_provider',
        'gateway_id',
    ];

    protected $casts = [
        'teams' => 'boolean',
        'per_seat' => 'boolean',
        'usable' => 'boolean',
        'synced_to_provider' => 'boolean',
    ];

    /**
     * Get the model's breadcrumb name.
     *
     * @return mixed
     */
    public function breadcrumbName()
    {
        return $this->name;
    }

    /**
     * Get a plan feature.
     *
     * @param  string  $key
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function feature($key)
    {
        return $this->features->where(function ($featurerable) use ($key) {
            return $featurerable->feature->key == $key;
        })->first();
    }

    /**
     * Determine if plan has the given feature.
     *
     * @return mixed
     */
    public function hasFeature(Feature $feature)
    {
        return $this->features->contains('feature_id', $feature->id);
    }

    /**
     * Determine if plan has or had subscribers.
     *
     * @return bool
     */
    public function hasSubscribers()
    {
        if ($this->teams) {
            return (bool) $this->teamSubscribers->count();
        }

        return (bool) $this->subscribers->count();
    }

    /**
     * Create plans and its related features.
     */
    public static function createPlan(array $plans)
    {
        foreach ($plans as $plan) {
            $newPlan = Plan::firstOrCreate([
                'provider_id' => $plan['provider_id'],
            ], [
                'name' => $plan['name'],
                'price' => $plan['price'],
                'teams' => $plan['teams'] ?? false,
                'per_seat' => $plan['per_seat'] ?? false,
                'usable' => $plan['usable'] ?? true,
            ]);

            foreach ($plan['features'] as $feature) {
                $f = Feature::firstOrCreate(['key' => Str::slug($feature['key'])], [
                    'name' => Str::title($feature['name']),
                    'usable' => true,
                ]);

                $default = $feature['default'] ?? false;

                $newPlan->features()->create([
                    'feature_id' => ($f->id),
                    'limit' => ($feature['limit']),
                    'default' => $default,
                ]);
            }
        }
    }

    /**
     * Scope query to include only the matching set of plans.
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeSearch(Builder $builder, $value)
    {
        if ($value == null) {
            return $builder;
        }

        return $builder->where('name', 'LIKE', '%'.$value.'%')
            ->orWhere('provider_id', 'LIKE', '%'.$value.'%')
            ->orWhereHas('features.feature', function ($query) use ($value) {
                $query->where('name', 'LIKE', '%'.$value.'%')
                    ->orWhere('key', 'LIKE', '%'.$value.'%');
            });
    }

    /**
     * Scope query to include only `active` plan features.
     *
     * @return Builder
     */
    public function scopeWithActiveFeatures(Builder $builder)
    {
        return $builder->with([
            'features.feature' => function ($query) {
                $query->active();
            },
        ]);
    }

    /**
     * Scope query to exclude given `plan`.
     *
     * @return Builder
     */
    public function scopeExcept(Builder $builder, $planId)
    {
        return $builder->where('id', '!=', $planId);
    }

    /**
     * Scope query to include only `team` plans.
     *
     * @return Builder
     */
    public function scopeForTeams(Builder $builder)
    {
        return $builder->where('teams', true);
    }

    /**
     * Scope query to include only `user` plans.
     *
     * @return Builder
     */
    public function scopeForUsers(Builder $builder)
    {
        return $builder->where('teams', false);
    }

    /**
     * Get all the plan's team subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teamSubscribers()
    {
        return $this->hasMany(CompanySubscription::class, 'stripe_price', 'provider_id');
    }

    /**
     * Get all the plan subscribers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscribers()
    {
        return $this->hasMany(Subscription::class, 'stripe_price', 'provider_id');
    }

    /**
     * Get all the plan's apps.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function apps()
    {
        return $this->hasMany(PlanApp::class);
    }

    /**
     * Get all the plan's features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features()
    {
        return $this->hasMany(PlanFeature::class);
    }
}
