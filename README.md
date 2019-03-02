
# The Sepiphy Laravel Console package

## Requirements

- Laravel [5.8](https://laravel.com/docs/5.8).

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


### Create a new class file.
```bash
php artisan make:class ClassName
```
If you want your class extend another class. You can use the `--extends` option.
```bash
php artisan make:class ClassName --extends=ParentClass
```
If you want your class implement an interface. You can use the `--implements` option.
```bash
php artisan make:class ClassName --implements=InterfaceName
```
Of course, a class can implement many interfaces.
```bash
php artisan make:class ClassName
--implements=FirstInterfaceName
--implements=SecondInterfaceName
--implements=TheOther
```
### Create a new interface file.
```bash
php artisan make:interface InterfaceName
```
If you want your interface extend another interface. You can use the `--extends` option.
```bash
php artisan make:interface InterfaceName --extends=ParentInterface
```
### Create a new trait file.
```bash
php artisan make:trait TraitName
```
### Search commands by keyword.
```bash
php artisan search AnyKeywords
php artisan search 'Any keywords'
```
### Set a variable in .env file.
```bash
php artisan env:set APP_NAME 'An Application Name'
```

## Contributing

Please visit [sepiphy/laravel-extensions](../../README.md) for more details!

## License

The `sepiphy/laravel-console` package is open-sourced software licensed under the [MIT license](LICENSE.md).
