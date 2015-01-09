<?php

namespace Opf\Route;

class Route implements RouteInterface
{
    protected $route;
    protected $regex;
    protected $matches;
    protected $values;

    protected $controller;
    protected $action;

    public function __construct($route, $controller, $action = 'main')
    {
        $this->route = $route;
        $this->regex = $route;

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

    public function __toString()
    {
        return $this->route;
    }

    public function getVar()
    {
        foreach($this->values as $key=>$match) {
            $this->values[$key] = $this->matches[$key];
       }

        return $this->values;
    }

    public function match($path)
    {
        $this->setRegex();

        return preg_match('#^' . $this->regex . '$#', $path, $this->matches);
    }

    public function setRegex()
    {
        $matches = array();
        preg_match_all('#{([a-z][a-zA-Z0-9_]*)}#', $this->regex, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $name = $match[1];
            $this->values[$name] = '';
            $find = '{'.$name.'}';
            $this->regex = str_replace($find, "(?P<{$name}>[^/]+)", $this->regex);
        }
    }
}
