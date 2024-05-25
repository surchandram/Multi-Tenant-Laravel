<?php

namespace SAAS\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RenameandUpdateMigrationFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename:migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update renamed migration files in migration table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $migrations = [
            '2020_01_17_204653_create_teams_table' => '2020_01_17_204653_create_companies_table',
            '2020_01_17_214301_create_team_user_table' => '2020_01_17_204653_create_company_user_table',
            '2020_01_21_114328_create_team_customer_columns' => '2020_01_17_204653_create_company_customer_columns',
            '2020_01_21_120248_create_team_subscriptions_table' => '2020_01_17_204653_create_company_subscriptions_table',
            '2020_01_21_130048_create_team_subscription_items_table' => '2020_01_17_204653_create_company_subscription_items_table',
            '2023_03_29_222747_add_personal_team_to_teams_table' => '2023_03_29_222747_add_personal_team_to_companies_table',
            '2020_01_17_204653_create_company_user_table' => '2020_01_17_214301_create_company_user_table',
            '2020_01_17_204653_create_company_customer_columns' => '2020_01_21_114328_create_company_customer_columns',
            '2020_01_17_204653_create_company_subscriptions_table' => '2020_01_21_120248_create_company_subscriptions_table',
            '2020_01_17_204653_create_company_subscription_items_table' => '2020_01_21_130048_create_company_subscription_items_table',
        ];

        foreach ($migrations as $oldname => $newname) {
            $i = DB::table('migrations')
                ->where('migration', $oldname)
                ->update([
                    'migration' => $newname,
                ]);

            if ($i > 0) {
                $this->info("Renamed [{$oldname}] to [{$newname}].");
            }
        }

        return Command::SUCCESS;
    }
}
