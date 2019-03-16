<?php declare(strict_types=1);

/*
 * This file is part of the Sepiphy package.
 *
 * (c) Quynh Xuan Nguyen <seriquynh@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sepiphy\Laravel\Console\Traits;

trait DecorateStub
{
    /**
     * @see \Illuminate\Console\GeneratorCommand
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $parent = $this->option('extends');
        $interfaces = $this->hasOption('implements') ? $this->option('implements') : null;

        if (!$parent && !$interfaces) {
            return parent::replaceNamespace($stub, $name);
        }

        $interfaceNames = '';
        $importInterfaces = '';
        if ($interfaces) {
            if (is_array($interfaces)) {
                $importInterfaces = '';
                foreach ($interfaces as $interface) {
                    $importInterfaces .= sprintf("use %s; \n", $interface);
                    $interfaceNames .= $this->getClassName($interface) . ', ';
                }
            } else {
                $importInterfaces = sprintf('use %s;', $interfaces);
                $interfaceNames .= $this->getClassName($interfaces);
            }
        }

        $namespace = $this->getNamespace($name);
        $name = $this->getClassName($name);
        $parentName = $this->getClassName($parent);

        $stub = strtr($stub, [
            'DummyNamespace' => $namespace,
            'DummyClass' => $name,
            'DummyParentFullName' => $parent,
            'DummyParentName' => $parentName,
            'DummyInterfaces' => trim($interfaceNames, ', '),
            'DummyImportInterfaces' => trim($importInterfaces, "\n"),
        ]);

        return $this;
    }

    /**
     * Get class name.
     *
     * @param  string  $class
     * @return string
     */
    public function getClassName($class)
    {
        return trim(substr($class, strrpos($class, '\\')), '\\');
    }
}
