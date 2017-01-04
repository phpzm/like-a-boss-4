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
     * @param $fragment
     * @return array
     */
    public function home($fragment)
    {
        return ['fragment' => $fragment];
    }

    /**
     * @param HeroRepository $repository
     * @param $id
     * @param $none
     * @return array
     */
    public function action(HeroRepository $repository, $id, $none)
    {
        return [
            'action' => [
                'parameters' => [$id, $none],
                'say' => $repository->say($this->model->say())
            ]
        ];
    }
}