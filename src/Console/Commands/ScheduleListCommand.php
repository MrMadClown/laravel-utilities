<?php

namespace MrMadClown\LaravelUtilities\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;

use function json_encode;

class ScheduleListCommand extends Command
{
    /** @var string */
    protected $signature = 'schedule:list';

    /**  @var string */
    protected $description = 'List the scheduled commands';

    public function handle(Schedule $schedule): void
    {
        $events = \collect($schedule->events());

        if ($events->isEmpty()) {
            $this->info('No scheduled events!');

            return;
        }

        $this->table($this->getHeaders(), $events->map(fn(Event $event): array => $this->getRowFrom($event)));
    }

    protected function getHeaders(): array
    {
        if ($this->option('verbose')) {
            return ['command', 'expression', 'evenInMaintenanceMode', 'withoutOverlapping', 'onOneServer'];
        }

        return ['command', 'expression'];
    }

    private function getRowFrom(Event $event): array
    {
        if ($this->option('verbose')) {
            return [
                $event->getSummaryForDisplay(),
                $event->expression,
                json_encode($event->evenInMaintenanceMode, JSON_THROW_ON_ERROR),
                json_encode($event->withoutOverlapping, JSON_THROW_ON_ERROR),
                json_encode($event->onOneServer, JSON_THROW_ON_ERROR),
            ];
        }

        return [$event->getSummaryForDisplay(), $event->expression];
    }
}
