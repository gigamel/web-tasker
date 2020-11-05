<?php
namespace abstractions;

abstract class Base
{
    /**
     * @param string $name
     */
    public function __get($name)
    {
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
    }
}