<?php

namespace Opf\Auth\Driver;

interface DriverInterface
{
    /**
     * @param string $username
     * @param string $password
     * @param array $group A list of group names to validate the User
     * @return bool
     *
     * @todo    implement the group feature for php arrays
     */
    public function isValid($username, $password, array $group = array());
}

?>