<?php

namespace MrMadClown\LaravelUtilities\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;

class CheckDatabaseSize extends Command
{
    protected $signature = 'app:db:check-size';

    protected $description = 'Display the Size of the Database in MB';

    public function handle(Connection $connection): int
    {
        $applicationDatabase = $connection->getDatabaseName();
        $dbSize = $connection
            ->table('information_schema.tables')
            ->select([
                'table_schema',
                $connection->raw('ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS size'),
            ])
            ->where('table_schema', $applicationDatabase)
            ->groupBy('table_schema')
            ->first();

        if (!$dbSize) {
            $this->error(\sprintf('Database %s not found!', $applicationDatabase));
            return 1;
        }

        $this->info(\sprintf('Database %s is currently at %sMB.', $dbSize->table_schema, $dbSize->size));

        return 0;
    }
}
