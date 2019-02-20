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
        $newValue = $this->quote($this->argument('value'));
        $oldValue = $this->env($name);

        if ($oldValue === null) {
            $this->appendVariable($name, $newValue);
            $this->info("A new environment variable '$name' has been set successfully.");

            return;
        }

        $this->setVariable($name, $newValue);
        $this->info("Environment variable '$name' has been changed from '$oldValue' to '$newValue'");
    }

    /**
     * Set value for existing variable.
     *
     * @param  string  $name
     * @param  string  $value
     * @return bool
     */
    public function setVariable($name, $value)
    {
        $replaced = preg_replace(
            $this->keyMatchingPattern($name),
            "$name=$value",
            file_get_contents($envFilePath = $this->laravel->environmentFilePath())
        );

        return file_put_contents($envFilePath, $replaced);
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
            $envFilePath = $this->laravel->environmentFilePath(),
            file_get_contents($envFilePath) . "\n$name=$value"
        );
    }

    /**
     * Add double quotation marks to a string which contains spaces.
     * If it doesn't, do nothing.
     *
     * @param  string  $string
     * @return string
     */
    public function quote($string)
    {
        return strpos($string, ' ') !== false ? sprintf('"%s"', $string) : $string;
    }

    /**
     * Get value of a key in .env file.
     *
     * @param  string  $key
     * @return mixed
     */
    public function env($key)
    {
        $isMatch = preg_match(
            $this->keyMatchingPattern($key),
            file_get_contents($this->laravel->environmentFilePath()),
            $matches
        );

        return $isMatch ? $matches[1] : null;
    }

    /**
     * Get a regex pattern that will match passed key.
     *
     * @param  string  $key
     * @return string
     */
    public function keyMatchingPattern($key)
    {
        return "/^$key=(.*)$/m";
    }
}
