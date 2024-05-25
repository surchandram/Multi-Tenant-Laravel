<?php

namespace SAAS\Domain\Plans\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SAAS\App\Support\Plans;

class PlanFeaturesSync
{
    use Dispatchable;

    /**
     * Whether missing plans should be created.
     *
     * @var bool $createMissing
     **/
    protected $createMissing = false;

    /**
     * Create a new job instance.
     *
     * @param  bool $createMissing
     * @return void
     */
    public function __construct()
    {
        // $this->createMissing = $createMissing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Plans::sync($this->createMissing);
    }
}
