<?php

namespace Opf\Route;

use Opf\Filter\FilterInterface;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class Router implements FilterInterface
{
    protected $routes = array();

    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
    }

    public function execute(
        RequestInterface $request, ResponseInterface $response
    ) {
        if (($route = $this->match($request->getUri())) !== null) {
            $request->setParameter('controller', $route->getController());
            $request->setParameter('action', $route->getAction());
            $var = $route->getVar();

            if (is_array($var)) {
                $request->setParameterFromArray($route->getVar());

            }
        }
    }

    /**
     * @param $uri
     *
     * @return Route
     */
    public function match($uri)
    {
        foreach ($this->routes as $route) {
            $result = $route->match($uri);

            if ($result == true) {
                return $route;
            }
        }
    }
}