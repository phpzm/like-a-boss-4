<?php

namespace Hero\Core;

/**
 * Class Router
 * @package Hero
 *
 * @method Router get($route, $callable)
 * @method Router post($route, $callable)
 * @method Router put($route, $callable)
 * @method Router delete($route, $callable)
 */
class Router
{
    /**
     * @var array
     */
    private $routes = [];

    /**
     * is triggered when invoking inaccessible methods in an object context.
     *
     * @param $name string
     * @param $arguments array
     * @return mixed
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.methods
     */
    function __call($name, $arguments)
    {
        return $this->on($name, isset($arguments[0]) ? $arguments[0] : '', isset($arguments[1]) ? $arguments[1] : '');
    }

    /**
     * @param $method
     * @param $path
     * @param $callback
     * @return $this
     */
    public function on($method, $path, $callback)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $uri = substr($path, 0, 1) !== '/' ? '/' . $path : $path;
        $pattern = str_replace('/', '\/', $uri);
        $route = '/^' . $pattern . '$/';

        $this->routes[$method][$route] = $callback;

        return $this;
    }

    /**
     * @param $method
     * @param $uri
     * @return mixed|null
     */
    public function match($method, $uri)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $route => $callback) {

            if (preg_match($route, $uri, $parameters)) {

                array_shift($parameters);

                return new Match($callback, $parameters);
            }
        }
        return null;
    }

}