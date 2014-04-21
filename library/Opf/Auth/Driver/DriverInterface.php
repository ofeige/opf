<?php

namespace Opf\Auth\Driver;

interface DriverInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param array $role A list of group names to validate the User
     * @return bool
     */
    public function isValid($username, $password, array $role = array());

    /**
     * @param string $username
     * @return array
     */
    public function getRoles($username);
}

?>
