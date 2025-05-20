<?php

namespace Holo\Commands;

use Illuminate\Console\Command;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     * @var string
     */
    protected $name = 'holo:migration';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Creates a migration following the Holo specifications.';

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command for Laravel 5.5+.
     * @return void
     */
    public function handle()
    {
        $this->laravel->view->addNamespace('holo', substr(__DIR__, 0, -8) . 'Views');

        $this->line('');

        $message = "A migration that creates necessary tables will be added to database/migrations directory.";

        $this->comment($message);
        $this->line('');

        if ($this->confirm("Proceed with the migration creation? [Yes|No]", "Yes")) {

            $this->line('');

            $this->info("Creating migration...");
            if ($this->createMigration()) {

                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Couldn't create migration.\n Check the write permissions" .
                    " within the database/migrations directory."
                );
            }

            $this->line('');

        }
    }

    /**
     * Create the migration.
     * @return bool
     */
    protected function createMigration()
    {

        $settingsTable = config('holo.settings_table', 'settings');
        $entitySettingsTable = config('holo.entity_settings_table', 'entity_settings');
        $allowedSettingValuesTable = config('holo.allowed_setting_values_table', 'allowed_setting_values');

        $migrationFile = base_path("/database/migrations") . "/" . date('Y_m_d_His') . "_create_holo_setup_tables.php";


        $data = compact('allowedSettingValuesTable', 'entitySettingsTable', 'settingsTable');

        $output = $this->laravel->view->make('holo::Generators.migration')->with($data)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);
            return true;
        }

        return false;
    }
}
