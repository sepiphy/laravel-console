<?php

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Nguyễn Xuân Quỳnh <nguyenxuanquynh2210vghy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Laravel\Console;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

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
}
