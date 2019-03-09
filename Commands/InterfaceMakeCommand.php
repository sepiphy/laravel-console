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

class InterfaceMakeCommand extends GeneratorCommand
{
    use DecorateStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface
                            {name : The interface name}
                            {--extends= : The interface parent}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface';

    /**
     * The type of element being generated.
     *
     * @var string
     */
    protected $type = 'Interface';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('extends')) {
            return __DIR__.'/../stubs/interface.parent.stub';
        }

        return __DIR__.'/../stubs/interface.stub';
    }
}
