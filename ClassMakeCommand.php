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

use Illuminate\Console\GeneratorCommand;

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
                            {--extends= : The class parent}';

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
            return __DIR__.'/stubs/class.parent.stub';
        }

        return __DIR__.'/stubs/class.stub';
    }
}
