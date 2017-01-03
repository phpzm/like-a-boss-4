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
     * @var HeroModel
     */
    private $model;

    /**
     * HeroController constructor.
     * @param HeroModel $model
     */
    public function __construct(HeroModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function home()
    {
        return 'Home';
    }

    /**
     * @param HeroRepository $repository
     * @param $parameters
     * @param $none
     * @return array
     */
    public function action(HeroRepository $repository, $parameters, $none)
    {
        return [
            'action' => [
                'parameters' => [$parameters, $none],
                'say' => $repository->say($this->model->say())
            ]
        ];
    }
}