<?php

namespace Opf\Auth\Driver;

interface DriverInterface
{
   /**
    * Prüft ob $username und $password stimmen
    *
    * @param string $username
    * @param string $password
    * @return bool
    */
   public function isValid($username, $password);
}

?>