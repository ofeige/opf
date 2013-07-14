<?php

namespace Opf\Event;

class Dispatcher
{
   private $handlers = array();
   static private $instance;

   /**
    * Return Instance of Dispatcher
    *
    * @return Dispatcher
    */
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

   /**
    * Trigger an Event
    *
    * @param mixed $event  Use instance of event or a String for a Event name
    * @param mixed $context
    * @param mixed $info
    * @return Event
    */
   public function triggerEvent(Event $event)
   {
      if (!$event instanceof Event) {
         $event = new Event($event, $context, $info);
      }
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
