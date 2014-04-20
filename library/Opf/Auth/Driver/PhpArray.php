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
     * @param string $username
     * @param string $password
     * @param array $group A list of group names to validate the User
     * @return bool
     *
     * @todo    implement the role feature for phpArrays
     */
    public function isValid($username, $password, array $group = array())
    {
        foreach ($this->data as $user => $pass) {
            if ($user == $username && $pass == $password) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $username
     * @return array
     * @todo    implement getRoles correct for phpArrays
     */
    public function getRoles($username)
    {

    }
}
