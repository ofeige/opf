<?php

namespace Opf\Mvc;

use Opf\Event\Event;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Event\Dispatcher;

abstract class CommandAbstract implements CommandInterface
{
    protected $request;
    protected $response;
    protected $aclGroup = false;

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

    public function getAcl()
    {
        return $this->aclGroup;
    }

    abstract function main();
}