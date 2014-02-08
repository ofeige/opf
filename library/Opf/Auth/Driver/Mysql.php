<?php

namespace Opf\Auth\Driver;

use \PDO;

class Mysql implements DriverInterface
{
   protected $modelName;

   public function __construct($modelName)
   {
      $this->modelName = $modelName;
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
       $user = \Model::factory('User')->where('email', $username)->find_one();

       return password_verify($password, $user->password);
   }
}
