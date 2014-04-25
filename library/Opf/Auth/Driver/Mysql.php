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
     * @param array $role A list of group names to validate the User
     * @return bool
     */
    public function isValid($username, $password, array $role = array())
    {
        if (count($role) > 0) {
            $user = \Model::factory($this->modelName)
                          ->left_outer_join('user_has_role', array('user.id', '=', 'user_has_role.user_id'))
                          ->left_outer_join('role', array('user_has_role.role_id', '=', 'role.id'))
                          ->where('email', $username)->where_in('role.name', $role)->find_one();
        } else {
            $user = \Model::factory($this->modelName)->where('email', $username)->find_one();
        }


        if ($user) {
            return password_verify($password, $user->password);
        }

        return false;
    }

    /**
     * @param string $username
     * @return array
     */
    public function getRoles($username)
    {
        $roles = \Model::factory($this->modelName)->select('role.name')
                       ->left_outer_join('user_has_role', array('user.id', '=', 'user_has_role.user_id'))
                       ->left_outer_join('role', array('user_has_role.role_id', '=', 'role.id'))
                       ->where('email', $username)->find_array();

        $array = array();
        foreach ($roles as $role) {
            $array[] = $role['name'];
        }

        return $array;
    }
}
