<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for a specific module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = $this->argument('module');
        $moduleData = Module::where('name', $module)->first();

        if (!$moduleData || !$moduleData->enabled) {
            $this->error("Module '{$module}' is not enabled or does not exist.");
            return;
        }

        $path = base_path("modules/{$module}/Migrations");
        Artisan::call('migrate', ['--path' => $path]);

        $moduleData->update(['last_migrated_at' => now()]);
        $this->info("Migrations for '{$module}' module completed.");
    }
}
