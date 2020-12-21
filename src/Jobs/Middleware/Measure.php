<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Measure
{
    public function __construct(
        private LoggerInterface $logger,
        private string $level = LogLevel::DEBUG
    ){
    }

    public function handle(object $job, callable $next): void
    {
        $timeStart = microtime(true);
        try {
            $next($job);
        } finally {
            $timeEnd = microtime(true);
            $this->logger->log($this->level,
                'Job measurement ends', [
                    'job' => class_basename($job),

                    'started' => $timeStart,
                    'ended' => $timeEnd,
                    'duration' => $timeEnd - $timeStart,
                ]);
        }
    }
}
