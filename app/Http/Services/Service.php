<?php


namespace App\Http\Services;

/**
 * 公用单例
*/
class Service
{

    protected static $_singleton;

    /**
     * @return $this
    */
    public static function getInstance()
    {
        $class = get_called_class();
        if (empty(self::$_singleton[$class])) {
            self::$_singleton[$class] = new $class();
        }

        return self::$_singleton[$class];
    }
}
