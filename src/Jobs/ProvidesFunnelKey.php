<?php

namespace MrMadClown\LaravelUtilities\Jobs;

interface ProvidesFunnelKey
{
    public function getFunnelKey(): string;
}
