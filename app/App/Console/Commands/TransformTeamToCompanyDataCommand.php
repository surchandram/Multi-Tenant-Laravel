<?php

namespace SAAS\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransformTeamToCompanyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refactor:team-to-company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all existing team related DB data to company';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = DB::table('roles')
            ->where('type', 'team')
            ->where('roleable_type', 'SAAS\Domain\Teams\Models\Team')
            ->update([
                'type' => 'company',
                'roleable_type' => 'SAAS\Domain\Companies\Models\Company',
            ]);

        $this->info("{$count} roles updated");

        $count = DB::table('roles')
            ->where('type', 'team')
            ->update([
                'type' => 'company',
            ]);

        $this->info("{$count} shared roles updated");

        $count = DB::table('permissions')
            ->where('type', 'team')
            ->update([
                'type' => 'company',
            ]);

        $this->info("{$count} permissions updated");

        $count = DB::table('media')
            ->where('model_type', 'SAAS\Domain\Teams\Models\Team')
            ->update([
                'model_type' => 'SAAS\Domain\Companies\Models\Company',
            ]);

        $this->info("{$count} media updated");

        return Command::SUCCESS;
    }
}
