<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class Measure
{
    private LoggerInterface $logger;
    private string $level;

    public function __construct(LoggerInterface $logger, string $level = LogLevel::DEBUG)
    {
        $this->logger = $logger;
        $this->level = $level;
    }

    public function handle($job, $next): void
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
