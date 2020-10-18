<?php

namespace MrMadClown\LaravelUtilities;

use Illuminate\Support\Str;

function parse_pusher_url(string $url): array
{
    $pusherUrl = parse_url($url);

    return array_map(static fn($value) => $value === '' ? null : $value, [
        'key' => data_get($pusherUrl, 'user'),
        'secret' => data_get($pusherUrl, 'pass'),
        'app_id' => Str::afterLast(data_get($pusherUrl, 'path'), '/'),
        'options' => [
            'cluster' => Str::after(Str::before(data_get($pusherUrl, 'host'), '.'), '-'),
        ],
    ]);
}

function parse_mysql_url(string $url): array
{
    $mysqlUrl = parse_url($url);

    return array_map(static fn($value) => $value === '' ? null : $value, [
        'host' => data_get($mysqlUrl, 'host'),
        'port' => data_get($mysqlUrl, 'port'),
        'database' => ltrim(data_get($mysqlUrl, 'path', ''), '/'),
        'username' => data_get($mysqlUrl, 'user'),
        'password' => data_get($mysqlUrl, 'pass'),
    ]);
}
