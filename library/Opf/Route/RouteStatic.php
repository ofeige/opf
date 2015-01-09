<?php

namespace Opf\Route;

class RouteStatic implements RouteInterface
{
    protected $route;
    protected $regex;
    protected $match;

    protected $controller;
    protected $action;

    public function __construct($route, $controller, $action = 'main')
    {
        $this->route = $route;

        $this->setController($controller);
        $this->setAction($action);
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getVar()
    {
        return;
    }

    public function __toString()
    {
        return $this->route;
    }

    public function match($path)
    {
        if($this->route == $path) {
            return true;
        }
    }
}
