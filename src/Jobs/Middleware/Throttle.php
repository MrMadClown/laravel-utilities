<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use MrMadClown\LaravelUtilities\Jobs\ProvidesThrottleKey;

class Throttle
{
    public function __construct(
        private int $limit = 1,
        private ?string $throttleKey = null,
        private int $delay = 10
    ){
    }

    public function handle(object $job, callable $next): void
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
