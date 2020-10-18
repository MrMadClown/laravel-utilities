# Laravel-Utilities 
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://poser.pugx.org/mrmadclown/laravel-utilities/v/stable.svg)](https://packagist.org/packages/mrmadclown/laravel-utilities)

## Installation
```bash
composer require mrmadclown/laravel-utilities
```
## Usage
If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php
```php
MrMadClown\LaravelUtilities\ServiceProvider::class,
```
### Commands

The ListModelsCommand takes a ModelClass (or Morph Alias) and multiple filter arguments.
The filter structure: [column]:[operator][value] or you can leave out the operator [column]:[value] (will resolve to '=')
A '*' will resolve to 'CONTAINS'.

```bash
php artisan app:list user
php artisan app:list \App\User::class
php artisan app:list user first_name:luc 
php artisan app:list user age:<26 
php artisan app:list user first_name:luc age:<26
php artisan app:list user first_name:luc age:<26
```
The ScheduleListCommand basically shows a table of all Scheduled Commands

```bash 
php artisan schedule:list
```
The CheckDatabaseSize Command displays how much space your database takes up.
```bash
php artisan app:db:check-size
```
### Traits
UsesUUID replaces the Model Key with an uuid
```php
use \MrMadClown\LaravelUtilities\Database\Eloquent\Model\UsesUUID;
```

### Helpers
Parse (HEROKU env) connection strings into LARAVEL config arrays 
```php
use function \MrMadClown\LaravelUtilities\parse_pusher_url;
use function \MrMadClown\LaravelUtilities\parse_mysql_url;
```

### Job Middleware

#### Funnel
Funnel jobs, takes overrides for `$limit=1`, `$funnelKey=get_class($job)` and `$delay=10` as constructor arguments.
The Job can implement `\MrMadClown\LaravelUtilities\Jobs\ProvidesFunnelKey` to provide `$funnelKey` at runtime. 
```php
use \MrMadClown\LaravelUtilities\Jobs\Middleware\Funnel;

function middleware(){
    return [new Funnel];
}
```
#### Throttle
Throttle jobs, takes overrides for `$limit=1`, `$throttleKey=get_class($job)` and `$delay=10` as constructor arguments.
The Job can implement `\MrMadClown\LaravelUtilities\Jobs\ProvidesThrottleKey` to provide `$throttleKey` at runtime. 
```php
use \MrMadClown\LaravelUtilities\Jobs\Middleware\Throttle;

function middleware(){
    return [new Throttle];
}
```

#### Measure
Measures Job Execution Time, requires a `\Psr\Log\LoggerInterface` and optionally a `LogLevel` as constructor arguments.
```php
use \MrMadClown\LaravelUtilities\Jobs\Middleware\Measure;

function middleware(){
    return [new Measure(logger(), \Psr\Log\LogLevel::INFO)];
}
```

