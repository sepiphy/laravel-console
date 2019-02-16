
# The Sepiphy Laravel Console package

## Requirements

- Laravel [5.5](https://laravel.com/docs/5.5), [5.6](https://laravel.com/docs/5.6) or [5.7](https://laravel.com/docs/5.7).

## Installation

Install the `sepiphy/laravel-console` package via Composer:

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

```bash
# Create a new class file.
php artisan make:class ClassName
# Create a new interface file.
php artisan make:interface InterfaceName
# Create a new trait file.
php artisan make:trait TraitName
# Search commands by keyword.
php artisan search AnyKeywords
php artisan search 'Any keywords'
# Set a variable in .env file.
php artisan env:set APP_NAME 'An Application Name'
```

## Contributing

Please visit [sepiphy/laravel-extensions](../../README.md) for more details!

## License

The `sepiphy/laravel-console` package is open-sourced software licensed under the [MIT license](LICENSE.md).
