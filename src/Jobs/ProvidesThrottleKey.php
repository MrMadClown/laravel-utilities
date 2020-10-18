<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 18.10.20
 */

namespace MrMadClown\LaravelUtilities\Jobs;

interface ProvidesThrottleKey
{
    public function getThrottleKey(): string;
}
