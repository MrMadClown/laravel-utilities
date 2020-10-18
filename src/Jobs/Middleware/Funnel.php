<?php

namespace MrMadClown\LaravelUtilities\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;

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

    public function handle($job, $next): void
    {
        Redis::funnel($this->funnelKey ?? class_basename($job))
            ->limit($this->limit)
            ->then(
                fn() => $next($job),
                fn() => $job->release($this->delay)
            );
    }
}
