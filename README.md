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
#### Commands

The ListModelsCommand takes a ModelClass (or Morph Alias) and multiple filter arguments.
The filter structure: [column]:[operator][value] or you can leave out the operator [column]:[value] (will resolve to '=')
A \* will resolve to 'CONTAINS'.

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

#### Traits
UsesUUID replaces the Model Key with an uuid
```php
use \MrMadClown\LaravelUtilities\Database\Eloquent\Model\UsesUUID;
```

