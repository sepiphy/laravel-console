<?php

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Sepiphy\Laravel\Console\Traits\DecorateStub;

class ClassMakeCommand extends GeneratorCommand
{
    use DecorateStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:class
                            {name : The class name}
                            {--extends= : The class parent}
                            {--implements=* : The interfaces}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new class';

    /**
     * The type of element being generated.
     *
     * @var string
     */
    protected $type = 'Class';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('extends')) {
            if ($this->option('implements')) {
                return __DIR__.'/../stubs/class.parent.interface.stub';
            }

            return __DIR__.'/../stubs/class.parent.stub';
        }

        if ($this->option('implements')) {
            return __DIR__.'/../stubs/class.interface.stub';
        }

        return __DIR__.'/../stubs/class.stub';
    }
}
