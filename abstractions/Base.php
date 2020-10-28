<?php
namespace abstractions;

abstract class Base
{
    /**
     * @param string $name
     */
    public function __get($name)
    {
        die("The property <strong>{$name}</strong> does not exist.");
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        die("The method <strong>{$name}</strong> does not exist.");
    }
}