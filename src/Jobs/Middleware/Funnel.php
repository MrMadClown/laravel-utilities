<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;
use MrMadClown\LaravelUtilities\Jobs\ProvidesFunnelKey;

class Funnel
{
    private ?string $funnelKey;
    private int $delay;
    private int $limit;

    public function __construct(int $limit = 1, string $funnelKey = null, int $delay = 10)
    {
        $this->limit = $limit;
        $this->funnelKey = $funnelKey;
        $this->delay = $delay;
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
