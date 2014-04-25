<?php

namespace Opf\Mvc;

use Opf\Event\Dispatcher;
use Opf\Event\Event;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

abstract class CommandAbstract implements CommandInterface
{
    protected $request;
    protected $response;
    protected $roles = false;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request  = $request;
        $this->response = $response;

        $event = Dispatcher::getInstance()->triggerEvent(new Event('CommandConstructor', $this));
        if ($event->isCancelled()) {
            $response->flush();
            exit;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    abstract function main();
}
