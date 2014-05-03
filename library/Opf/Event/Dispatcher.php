<?php

namespace Opf\Event;

class Dispatcher
{
    private $handlers = array();
    static private $instance;

    static public function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Dispatcher();
        }

        return self::$instance;
    }

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    public function addHandler($eventName, HandlerInterface $handler)
    {
        if (!isset($this->handlers[$eventName])) {
            $this->handlers[$eventName] = array();
        }

        $this->handlers[$eventName][] = $handler;
    }

    public function triggerEvent(Event $event)
    {
        $eventName = $event->getName();
        if (!isset($this->handlers[$eventName])) {
            return $event;
        }
        foreach ($this->handlers[$eventName] as $handler) {
            $handler->handle($event);
            if ($event->isCancelled()) {
                break;
            }
        }

        return $event;
    }
}
