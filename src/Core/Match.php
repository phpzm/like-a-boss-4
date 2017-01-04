<?php
/*
 -------------------------------------------------------------------
 | @project: like-a-boss-4
 | @package: Hero\Core
 | @file: ${FILE_NAME}
 -------------------------------------------------------------------
 | @user: william 
 | @creation: 02/01/17 23:54
 | @copyright: fagoc.br / gennesis.io / arraysoftware.net
 | @license: MIT
 -------------------------------------------------------------------
 | @description:
 | PHP class
 |
 */

namespace Hero\Core;

/**
 * Class Match
 * @package Hero\Core
 */
class Match
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    private $options;

    /**
     * Match constructor.
     * @param $callable
     * @param $parameters
     * @param array $options
     */
    public function __construct($callable, $parameters, $options = [])
    {
        $this->callable = $callable;
        $this->parameters = $parameters;
        $this->options = $options;
    }

    /**
     * @return callable
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @param callable $callable
     * @return Match
     */
    public function setCallable($callable)
    {
        $this->callable = $callable;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return Match
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Match
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

}