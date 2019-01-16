
# Laravel Console Extension

## Requirements

- Laravel [5.6](https://laravel.com/docs/5.6) or [5.7](https://laravel.com/docs/5.7).

## Installation

You should install the `sepiphy/laravel-console` dependency via Composer:

```bash
composer require sepiphy/laravel-console
```

Then, you have to add the `Sepiphy\Laravel\Console\ConsoleServiceProvider` class to the `config/app.php` configuration file.

```php
return [

    'providers' => [

        /*
         * Package Service Providers...
         */
        Sepiphy\Laravel\Console\ConsoleServiceProvider::class,

    ],

];
```

## Usage

These are available commands now:

```bash
# Create a new class file.
php artisan make:class ClassName
# Create a new interface file.
php artisan make:interface InterfaceName
# Create a new trait file.
php artisan make:trait TraitName
# Search commands by keyword.
php artisan search OneWord
php artisan search 'Some words that you want to search'
```
