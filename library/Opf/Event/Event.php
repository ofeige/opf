<?php

namespace Opf\Event;

class Event implements EventInterface
{
    private $name;
    private $context;
    private $info;
    private $cancelled = false;

    public function __construct($name, $context = null, $info = null)
    {
        $this->name    = $name;
        $this->context = $context;
        $this->info    = $info;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function isCancelled()
    {
        return $this->cancelled;
    }

    public function cancel()
    {
        $this->cancelled = true;
    }
}
