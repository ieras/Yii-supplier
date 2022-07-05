<?php

namespace app\utils;

class BaseUtil
{
    protected static $service = [];

    /**
     * @Method  instance
     *
     * @static
     * @return static
     */
    public static function instance(){
        if (!isset(self::$service[static::class]))
            self::$service[static::class] = new static();
        return self::$service[static::class];
    }

}
