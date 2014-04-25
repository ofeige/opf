<?php

namespace Opf\Session;

class Php implements SessionInterface, \ArrayAccess
{
    private $container;

    public function __construct()
    {
        // Start the session suppress error if already started
        if (session_id() == '') {
            @session_start();
            if (session_id() == '') {
                throw new Exception('Cannot start session');
            }

            $this->container = & $_SESSION;
        }
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
