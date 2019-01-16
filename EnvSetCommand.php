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

use Illuminate\Console\Command;

class EnvSetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set
                            {name : The environment variable name}
                            {value : The environment variable value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an environment variable in .env file.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('name');
        $newValue = $this->argument('value');
        $oldValue = env($name);

        if ($oldValue === null) {
            $this->appendVariable($name, $newValue);

            return $this->info("A new environment variable '$name' has been set successfully.");
        }

        $this->setVariable($name, $newValue, $oldValue);

        return $this->info("Environment variable '$name' has been changed from '$oldValue' to '$newValue'");
    }

    /**
     * Set value for existing variable.
     *
     * @param  string  $name
     * @param  string  $value
     * @return bool
     */
    public function setVariable($name, $newValue, $oldValue)
    {
        $replaced = str_replace(
            "$name=$oldValue",
            "$name=$newValue",
            file_get_contents($envPath = $this->laravel->environmentFilePath())
        );

        return file_put_contents(
            $envPath,
            $replaced
        );
    }

    /**
     * Append an variable to .env file.
     *
     * @param  string  $name
     * @param  string  $value
     * @return bool
     */
    public function appendVariable($name, $value)
    {
        return file_put_contents(
            $envPath = $this->laravel->environmentFilePath(),
            file_get_contents($envPath) . "\n$name=$value"
        );
    }
}
