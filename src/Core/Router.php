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
     * @var bool
     */
    protected $labels = false;

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
     * @param array $options
     * @return $this
     */
    public function on($method, $path, $callback, $options = [])
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $uri = substr($path, 0, 1) !== '/' ? '/' . $path : $path;

        $pieces = explode('/', $uri);
        $labels = [];
        foreach ($pieces as $key => $piece) {
            $label = '';
            $regex = $piece;
            if (substr($piece, 0, 1) === ':') {
                $regex = '(\w+)';
                $label = substr($piece, 1);
            }
            if (substr($piece, -1) === '*') {
                $regex = '(.*)';
                $label = substr($piece, 1, -1);
            }
            if ($label) {
                $labels[] = $label;
            }
            $pieces[$key] = $regex;
        }

        $pattern = str_replace('/', '\/', implode('/', $pieces));
        $route = '/^' . $pattern . '$/';

        $this->routes[$method][$route] = [
            'callback' => $callback,
            'labels' => $labels,
            'options' => $options
        ];

        return $this;
    }

    /**
     * @param $method
     * @param $route
     * @return Match|null
     */
    public function match($method, $route)
    {
        $method = strtolower($method);
        if (!isset($this->routes[$method])) {
            return null;
        }

        foreach ($this->routes[$method] as $candidate => $callable) {

            if (preg_match($candidate, $route, $parameters)) {

                array_shift($parameters);

                $callback = $callable['callback'];
                $labels = $callable['labels'];
                $options = $callable['options'];
                $data = $parameters;
                if ($this->labels || (isset($options['labels']) ? $options['labels'] : false)) {
                    foreach ($labels as $key => $label) {
                        $data[$label] = $parameters[$key];
                    }
                }

                return new Match($callback, $data, $options);
            }
        }
        return null;
    }

}