<?php

namespace Opf\Auth\Driver;

class Mysql implements DriverInterface
{
   protected $dbHandle;

   public function __construct($dsn, $username, $password)
   {
      $this->dbHandle = new PDO($dsn, $username, $password);
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
      $sth = $this->dbHandle->prepare('select id from user where email=? and passwd=sha2(?, 512)');
      $sth->bindParam(1, $username, PDO::PARAM_STR, 256);
      $sth->bindParam(2, $password, PDO::PARAM_STR, 128);
      $sth->execute();

      if(($id = $sth->fetchColumn()) === false) {
         return false;
      }

      $sth = $this->dbHandle->query('select group_concat(store_id) from user_follow where user_id='.$id.' group by user_id');

      return array(
         'user_id' => $id,
         'email' => $username,
         'follows' => $sth->fetchColumn(0)
      );
   }
}
