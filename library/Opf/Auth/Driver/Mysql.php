<?php

namespace Opf\Auth\Driver;

class Mysql implements DriverInterface
{
   protected $modelName;

   public function __construct($modelName)
   {
      $this->modelName = $modelName;
   }

   /**
    * @param string $username
    * @param string $password
    * @param array $group A list of group names to validate the User
    * @return bool
    */
    public function isValid($username, $password, array $group = array())
    {
        if (count($group) > 0) {
            $user = \Model::factory($this->modelName)
                          ->left_outer_join('user_has_group', array('user.id', '=', 'user_has_group.user_id'))
                          ->left_outer_join('group', array('user_has_group.group_id', '=', 'group.id'))
                          ->where('email', $username)->where_in('group.name', $group)->find_one();
        } else {
            $user = \Model::factory($this->modelName)->where('email', $username)->find_one();
        }


        if ($user) {
            return password_verify($password, $user->password);
        }

       return false;
   }
}
