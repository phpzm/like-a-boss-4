<?php

namespace Hero\App;

use Hero\Core\Controller;

/**
 * Class HeroController
 * @package Hero\App
 */
class HeroController extends Controller
{
    /**
     * @param $parameters
     * @return mixed
     */
    public function action($parameters)
    {
        return [
            'action' => $parameters
        ];
    }

}