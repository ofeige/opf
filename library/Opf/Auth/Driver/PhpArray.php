<?php

namespace Opf\Auth\Driver;

class PhpArray implements DriverInterface
{
   private $data;

   public function __construct(array $data)
   {
      $this->data = $data;
   }

   /**
    * Prüft ob Benutzername und Passwort stimmen
    *
    * @param string $username
    * @param string $password
    * @return bool
    */
   public function isValid($username, $password)
   {
      foreach ($this->data as $user => $pass) {
         if ($user == $username && $pass == $password) {
            return true;
         }
      }

      return false;
   }
}
