<?php

namespace SAAS\Domain\Tenant\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SetupTenantFeature
{
    use Dispatchable, SerializesModels;

    /**
     * An instance of a tenant or an array of tenant ids.
     *
     * @var \Miracuthbert\Multitenancy\Models\Tenant|array
     */
    public $tenant;

    /**
     * The key to the feature being setup.
     *
     * @var string
     */
    public $feature;

    /**
     * Set whether setup should be done in the background.
     *
     * @var bool
     */
    public $runInBackground;

    /**
     * Create a new event instance.
     *
     * @param  \Miracuthbert\Multitenancy\Models\Tenant|array $tenant
     * @param  string $feature
     * @param  bool $runInBackground
     * @return void
     */
    public function __construct($tenant, $feature, $runInBackground = false)
    {
        $this->tenant = $tenant;
        $this->feature = $feature;
        $this->runInBackground = $runInBackground;
    }
}
