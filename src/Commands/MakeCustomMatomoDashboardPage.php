<?php

namespace Agencetwogether\MatomoAnalytics\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCustomMatomoDashboardPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:matomo-page {name : The page class name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Custom Matomo Analytics Filament dashboard page';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name');

        $className = Str::studly($name);

        $namespace = 'App\\Filament\\Pages';

        $path = app_path("Filament/Pages/{$className}.php");

        if (File::exists($path)) {
            $this->error("Page {$className} already exists.");

            return self::FAILURE;
        }

        $stub = File::get(__DIR__ . '/../../stubs/matomo-dashboard-page.stub');

        $content = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$namespace, $className],
            $stub
        );

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $content);

        $this->info("Filament page {$className} created successfully.");

        return self::SUCCESS;
    }
}
