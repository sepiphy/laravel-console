<?php declare(strict_types=1);

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Laravel\Console;

use Illuminate\Support\ServiceProvider;
use Sepiphy\Laravel\Console\Commands\EnvSetCommand;
use Sepiphy\Laravel\Console\Commands\SearchCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Sepiphy\Laravel\Console\Commands\AppNameCommand;
use Sepiphy\Laravel\Console\Commands\ClassMakeCommand;
use Sepiphy\Laravel\Console\Commands\TraitMakeCommand;
use Sepiphy\Laravel\Console\Commands\InterfaceMakeCommand;

class ConsoleServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The supported commands.
     *
     * @var array
     */
    protected $commands = [
        'ClassMakeCommand' => 'command.class.make',
        'InterfaceMakeCommand' => 'command.interface.make',
        'TraitMakeCommand' => 'command.trait.make',
        'SearchCommand' => 'command.search',
        'EnvSetCommand' => 'command.env.set',
        'AppNameCommand' => 'command.app.name',
    ];

    /**
     * Register any services for the application.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->commands as $command => $name) {
            $this->{'register'.$command}($name);
        }

        $this->commands(array_values($this->commands));
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return array_values($this->commands);
    }

    /**
     * Register the command.
     *
     * @param  string  $name
     * @return void
     */
    protected function registerClassMakeCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new ClassMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @param  string  $name
     * @return void
     */
    protected function registerInterfaceMakeCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new InterfaceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @param  string  $name.
     * @return void
     */
    protected function registerTraitMakeCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new TraitMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @param  string  $name.
     * @return void
     */
    protected function registerSearchCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new SearchCommand;
        });
    }

    /**
     * Register the command.
     *
     * @param  string  $name
     * @return void
     */
    protected function registerEnvSetCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new EnvSetCommand;
        });
    }

    /**
     * Register the command.
     *
     * @param  string  $name
     * @return void
     */
    protected function registerAppNameCommand($name)
    {
        $this->app->singleton($name, function ($app) {
            return new AppNameCommand($app['composer'], $app['files']);
        });
    }
}
