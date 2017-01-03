<?php

namespace Hero\Core;

use Hero\Http\Request;

/**
 * Class App
 * @package Hero\Core
 */
class App
{
    /**
     * @param $callable
     */
    public function http($callable)
    {
        $request = new Request();
    }

    public function handler()
    {
    }

    /**
     * @param $callback
     * @param $parameters
     * @return mixed
     */
    public function call($callback, $parameters)
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $parameters);
        }
        return null;
    }
}