<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 18.10.20
 */

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

    public function handle($job, $next): void
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

    private function getThrottleKey($job): string
    {
        if ($job instanceof ProvidesThrottleKey) {
            return $job->getThrottleKey();
        }

        return $this->throttleKey ?? class_basename($job);
    }
}
