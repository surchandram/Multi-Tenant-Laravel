<?php

namespace SAAS\Domain\Tenant\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Miracuthbert\Multitenancy\Events\TenantIdentified;
use SAAS\Domain\Tenant\Events\SetupTenantFeature;

class HandleFeaturesSetup
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Miracuthbert\Multitenancy\Events\TenantIdentified  $event
     * @return void
     */
    public function handle(TenantIdentified $event)
    {
        // make sure primary migrations are run
        $migration = Artisan::call('tenants:migrate', [
            '--tenants' => [$event->tenant->id],
        ]);

        if ($migration === 0) {
            // log here
        }

        // get tenant plan
        $plan = $event->tenant->plan;

        if (!$plan) {
            return;
        }

        // get migrateable plan features
        $features = $plan->features->where(fn($planFeature) => $this->resolveKeyPresence($planFeature->feature->key));

        // loop through and migrate the features
        foreach ($features as $planFeature) {
            $key = $planFeature->feature->key;

            event(new SetupTenantFeature($event->tenant, $key));
        }
    }

    /**
     * Resolve feature key presence from an array of migration keys.
     *
     * Undocumented function long description
     *
     * @param string $key Value of a feature key
     * @return bool
     **/
    public function resolveKeyPresence(string $key)
    {
        return in_array($key, array_keys(config('saas.features.migrations')));
    }
}
