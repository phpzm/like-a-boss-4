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
        $default = ['separator' => '@'];
        $this->options = array_merge($default, $options);

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
        $response = $this->call($match->getCallable(), $match->getParameters());
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
     * @param bool $embed
     * @return mixed|null
     */
    private function call($callable, $parameters, $embed = true)
    {
        if (is_callable($callable)) {
            if ($embed) {
                $parameters = [$this->request, $this->response, $parameters];
            }
            return call_user_func_array($callable, $parameters);
        } else {
            $pieces = explode($this->options['separator'], $callable);
            if (isset($pieces[0]) && isset($pieces[1])) {
                $container = Container::getInstance();
                $class = $pieces[0];
                $method = $pieces[1];
                $instance = $container->make($class);
                if (is_callable($instance)) {
                    $instance($this->request, $this->response);
                }
                $parameters = $container->makeParameters($instance, $method, $parameters);

                return $this->call([$instance, $method], $parameters, false);
            }
        }
        return null;
    }

}