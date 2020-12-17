<?php

namespace MrMadClown\LaravelUtilities\Jobs;

interface ProvidesThrottleKey
{
    public function getThrottleKey(): string;
}
