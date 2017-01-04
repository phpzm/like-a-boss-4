<?php

namespace Hero\Core;

use Hero\Http\Request;
use Hero\Http\Response;

/**
 * Class App
 * @package Hero\Core
 */
class App extends Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var array
     */
    private $options;

    /**
     * App constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $default = [
            'separator' => '@',
            'labels' => false
        ];
        $this->options = array_merge($default, $options);

        $this->labels = $this->options['labels'];

        $this->request = new Request();
        $this->response = new Response();

        Container::getInstance()
            ->register(Request::class, $this->request)
            ->register(Response::class, $this->response);
    }

    /**
     * @param bool $print
     * @return Response|string
     */
    public function handler($print = true)
    {
        $response = $this->response->withStatus(404);

        $match = $this->match($this->request->getMethod(), $this->request->getUri()->getRoute());
        if ($match) {
            $response = $this->parse($match);
        }

        if ($print) {
            http_response_code($response->getStatusCode());
            echo $response->getBody()->getContents();
        }

        return $response;
    }

    /**
     * @param Match $match
     * @return Response
     */
    private function parse(Match $match)
    {
        $response = $this->call($match->getCallable(), $match->getParameters(), $match->getOptions());
        if (!($response instanceof Response)) {
            $plain = in_array(gettype($response), ['boolean', 'integer', 'double', 'string']);
            $string = ($plain) ? ((string)$response) : (is_null($response) ? '' : json_encode($response));
            $response = $this->response;
            $response->getBody()->write($string);
        }
        return $response;
    }

    /**
     * @param $callable
     * @param $parameters
     * @param $options
     * @param bool $make
     * @return mixed|null
     */
    private function call($callable, $parameters, $options = [], $make = true)
    {
        $container = Container::getInstance();

        $labels = isset($options['labels']) ? $options['labels'] : $this->labels;
        if (is_callable($callable)) {
            if ($make) {
                $parameters = $container->resolveFunctionParameters($callable, $parameters, $labels);
            }
            return call_user_func_array($callable, $parameters);
        } else {
            $pieces = explode($this->options['separator'], $callable);
            if (isset($pieces[0]) && isset($pieces[1])) {
                $class = $pieces[0];
                $method = $pieces[1];
                $instance = $container->make($class);
                if (is_callable($instance)) {
                    $instance($this->request, $this->response);
                }
                $parameters = $container->resolveMethodParameters($instance, $method, $parameters, $labels);

                return $this->call([$instance, $method], $parameters, $options, false);
            }
        }
        return null;
    }

}