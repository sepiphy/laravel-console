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

trait DecorateStub
{
    /**
     * @see \Illuminate\Console\GeneratorCommand
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        if (!$parent = $this->option('extends')) {
            return parent::replaceNamespace($stub, $name);
        }

        $namespace = $this->getNamespace($name);
        $name = trim(substr($name, strrpos($name, '\\')), '\\');
        $parentName = trim(substr($parent, strrpos($parent, '\\')), '\\');

        $stub = str_replace(
            [
                'DummyNamespace',
                'DummyClass',
                'DummyParentFullName',
                'DummyParentName',
            ],
            [
                $namespace,
                $name,
                $parent,
                $parentName,
            ],
            $stub
        );

        return $this;
    }
}
