<?php

namespace Hero\App;

use Hero\Http\Request;
use Hero\Http\Response;

/**
 * Class HeroController
 * @package Hero\App
 */
class HeroController
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
     * HeroController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param $parameters
     */
    public function action($parameters)
    {
        return $this->getResponse();
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}