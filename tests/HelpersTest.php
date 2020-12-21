<?php

namespace MrMadClown\LaravelUtilities\Tests;

use PHPUnit\Framework\TestCase;
use function MrMadClown\LaravelUtilities\parse_mysql_url;
use function MrMadClown\LaravelUtilities\parse_pusher_url;

class HelpersTest extends TestCase
{
    public function pusherProvider(): \Generator
    {
        yield [
            'http://user:pass@api-mt1.pusher.com/my-app',
            [
                'key' => 'user',
                'secret' => 'pass',
                'app_id' => 'my-app',
                'options' => [
                    'cluster' => 'mt1',
                ],
            ],
        ];
    }

    /** @dataProvider pusherProvider */
    public function testParsePusherURL(string $url, array $expected): void
    {
        static::assertEquals($expected, parse_pusher_url($url));
    }

    public function mysqlProvider(): \Generator
    {
        yield [
            'mysql://user:pass@some-db.com:1337/my-database',
            [
                'host' => 'some-db.com',
                'port' => '1337',
                'database' => 'my-database',
                'username' => 'user',
                'password' => 'pass',
            ],
        ];
    }

    /** @dataProvider mysqlProvider */
    public function testParseMysqlURL(string $url, array $expected): void
    {
        static::assertEquals($expected, parse_mysql_url($url));
    }
}
