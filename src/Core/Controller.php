<?php

namespace Hero\Core;

use Hero\Http\Request;
use Hero\Http\Response;

/**
 * Class HeroController
 * @package Hero\App
 */
class Controller
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
     * @param Request $request
     * @param Response $response
     * @return $this
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;

        return $this;
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