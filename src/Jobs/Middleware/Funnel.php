<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use MrMadClown\LaravelUtilities\Jobs\ProvidesFunnelKey;

class Funnel
{
    public function __construct(
        private int $limit = 1,
        private ?string $funnelKey = null,
        private int $delay = 10
    ){
    }

    public function handle(object $job, \Closure|callable $next): void
    {
        Redis::funnel($this->getFunnelKey($job))
            ->limit($this->limit)
            ->then(
                fn() => $next($job),
                fn() => $job->release($this->delay)
            );
    }

    private function getFunnelKey(object $job): string
    {
        if ($job instanceof ProvidesFunnelKey) {
            return $job->getFunnelKey();
        }

        return $this->funnelKey ?? class_basename($job);
    }
}
