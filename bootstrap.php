<?php

require ('vendor/autoload.php');

use Opf\Registry\Registry;
use Opf\Mvc\CommandResolver;
use Opf\Mvc\Controller;
use Opf\Http\Request;
use Opf\Http\Response;
use Opf\Session\Php;

define('OPF_APPLICATION_PATH', __DIR__.'/testapp');
chdir(OPF_APPLICATION_PATH);

$request = new Request();
$response = new Response();
$session = new Php();

Registry::getInstance()->setSession($session);

$resolver = new CommandResolver(OPF_APPLICATION_PATH, 'Info');
$controller = new Controller($resolver);
$controller->handleRequest($request, $response);