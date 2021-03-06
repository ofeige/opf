<?php

namespace Opf\Session;

class Php implements SessionInterface, \ArrayAccess
{
    private $container;

    public function __construct()
    {
        $this->start();
    }

    public function start($lifetime = 0)
    {
        if (session_id() == '') {

            session_set_cookie_params($lifetime);
            session_start();
            if (session_id() == '') {
                throw new Exception('Cannot start session');
            }

            $this->container = & $_SESSION;
        }
    }

    public function setLifetime($lifetime)
    {
        session_set_cookie_params($lifetime);
        session_regenerate_id(true);
    }

    public function destroy()
    {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    public function issetParameter($name)
    {
        return isset($this->container[$name]);
    }

    public function getParameter($name)
    {
        if ($this->issetParameter($name) === true) {
            return $this->container[$name];
        }

        return null;
    }

    public function setParameter($name, $value)
    {
        $this->container[$name] = $value;
    }

    public function unsetParameter($name)
    {
        if ($this->issetParameter($name) === true) {
            unset($this->container[$name]);
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}
