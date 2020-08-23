<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 23.08.20
 */

namespace MrMadClown\LaravelUtilities;

use MrMadClown\LaravelUtilities\Console\Commands\ListModelsCommand;
use MrMadClown\LaravelUtilities\Console\Commands\ScheduleListCommand;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $commands = [
        ListModelsCommand::class,
        ScheduleListCommand::class,
    ];

    public function register()
    {
        if ($this->app->runningInConsole()) $this->registerCommands();
    }

    private function registerCommands(): void
    {
        $this->commands($this->commands);
    }
}
