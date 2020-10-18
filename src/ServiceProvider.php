<?php

namespace MrMadClown\LaravelUtilities;

use MrMadClown\LaravelUtilities\Console\Commands\CheckDatabaseSize;
use MrMadClown\LaravelUtilities\Console\Commands\ListModelsCommand;
use MrMadClown\LaravelUtilities\Console\Commands\ScheduleListCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected array $commands = [
        ListModelsCommand::class,
        ScheduleListCommand::class,
        CheckDatabaseSize::class,
    ];

    public function register(): void
    {
        if ($this->app->runningInConsole()) $this->registerCommands();
    }

    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }
}
