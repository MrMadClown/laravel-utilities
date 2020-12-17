<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use MrMadClown\LaravelUtilities\Jobs\ProvidesThrottleKey;

class Throttle
{
    private ?string $throttleKey;
    private int $delay;
    private int $limit;

    public function __construct(int $limit = 1, string $throttleKey = null, int $delay = 10)
    {
        $this->limit = $limit;
        $this->throttleKey = $throttleKey;
        $this->delay = $delay;
    }

    public function handle(object $job, \Closure|callable $next): void
    {
        Redis::throttle($this->getThrottleKey($job))
            ->block(0)
            ->allow($this->limit)
            ->every($this->delay)
            ->then(
                fn() => $next($job),
                fn() => $job->release($this->delay)
            );
    }

    private function getThrottleKey(object $job): string
    {
        if ($job instanceof ProvidesThrottleKey) {
            return $job->getThrottleKey();
        }

        return $this->throttleKey ?? class_basename($job);
    }
}
