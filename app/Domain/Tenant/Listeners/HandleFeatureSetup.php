<?php

namespace SAAS\Domain\Tenant\Listeners;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Miracuthbert\Multitenancy\Models\Tenant;
use SAAS\Domain\Tenant\Events\SetupTenantFeature;

class HandleFeatureSetup
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
     * @param  \SAAS\Domain\Tenant\Events\SetupTenantFeature  $event
     * @return void
     */
    public function handle(SetupTenantFeature $event)
    {
        $tenants = $this->resolveTenants($event->tenant);
        $feature = $event->feature;

        if (empty($feature) || !$this->resolveKeyPresence($feature))  {
            return;
        }

        // get feature migrations path
        $path = config("saas.features.migrations.{$feature}");

        // run feature migrations
        $migration = Artisan::call('tenants:migrate', ($args = [
            '--tenants' => $tenants,
            '--path' => $path,
            '--realpath' => true
        ]));

        if ($migration === 0) {
            // log success message here
        } else {
            logger()->debug('Failed when running command [tenants:migrate] with following arguments:', $args);
        }
    }

    /**
     * Resolve tenant from passed value.
     *
     * @param \Miracuthbert\Multitenancy\Models\Tenant|array $value Tenant instance or array of ids
     * @return array
     **/
    public function resolveTenants($value)
    {
        return $value instanceof Tenant ? [$value->id] : $this->resolvedValues($value);
    }

    /**
     * Resolve valid tenants ids from value.
     *
     * @param array|mixed $value Value to parse
     * @return array
     **/
    public function resolvedValues($value)
    {
        return is_numeric($value) ? [$value] : array_filter($value, fn ($id) => is_numeric($id));
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
