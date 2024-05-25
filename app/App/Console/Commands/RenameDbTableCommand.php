<?php

namespace SAAS\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class RenameDbTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:rename {old} {new}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename a db table and update its migration name';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (
            ! $this->rename(
                $oldname = $this->argument('old'),
                $newname = $this->argument('new')
            )
        ) {
            $this->error("{$oldname} could not be renamed to {$newname}");

            return Command::FAILURE;
        }

        $this->info('Table renamed successfully');

        return Command::SUCCESS;
    }

    protected function rename($oldname, $newname)
    {
        Schema::disableForeignKeyConstraints();
        Schema::rename($oldname, $newname);
        Schema::enableForeignKeyConstraints();

        return Schema::hasTable($newname);
    }
}
