<?php

namespace Opf\Event;

interface EventInterface
{
    public function getName();

    public function cancel();

    public function isCancelled();
}
