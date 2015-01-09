<?php

namespace Opf\Route;

interface RouteInterface
{
    public function match($path);
    public function getController();
    public function getAction();
    public function getVar();
}