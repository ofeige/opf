<?php

namespace Opf\Session;

class Php implements SessionInterface
{
   public function __construct()
   {
      // Start the session suppress error if already started
      if (session_id() == '') {
         @session_start();
         if (session_id() == '') {
            throw new Exception('Cannot start session');
         }
      }
   }

   public function issetParameter($name)
   {
      return isset($_SESSION[$name]);
   }

   public function getParameter($name)
   {
      if ($this->issetParameter($name) === true) {
         return $_SESSION[$name];
      }

      return NULL;
   }

   public function setParameter($name, $value)
   {
      $_SESSION[$name] = $value;
   }

   public function unsetParameter($name)
   {
      if ($this->issetParameter($name) === true) {
         unset($_SESSION[$name]);
      }
   }
}

?>