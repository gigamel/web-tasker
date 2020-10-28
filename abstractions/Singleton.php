<?php
namespace abstractions;

abstract class Singleton extends Base
{
    /**
     * @var object $app
     */
    public static $app;

    /**
     * @return object
     */
    final public static function createInstance()
    {
        if (is_null(static::$app)) {
            static::$app = new static();
        }

        return static::$app;
    }

    protected function __construct() {
    }
}