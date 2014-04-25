<?php

namespace Opf\Event;

interface HandlerInterface
{
    public function handle(Event $event);
}
