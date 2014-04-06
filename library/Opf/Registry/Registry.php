<?php

namespace Opf\Registry;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Opf\Session\SessionInterface;

class Registry
{
    protected static $instance = null;
    protected $values = array();

    const KEY_REQUEST  = 'request';
    const KEY_RESPONSE = 'response';
    const KEY_SESSION  = 'session';
    const KEY_LOGGER   = 'logger';

    /**
     * return instance of Registry
     *
     * @return Registry
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }

        return self::$instance;
    }

    protected function __construct()
    {
    }

    private function __clone()
    {
    }

    protected function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return null;
    }

    public function setRequest(RequestInterface $request)
    {
        $this->set(self::KEY_REQUEST, $request);
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->set(self::KEY_RESPONSE, $response);
    }

    public function setSession(SessionInterface $session)
    {
        $this->set(self::KEY_SESSION, $session);
    }

    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->set(self::KEY_LOGGER, $logger);
    }

    /**
     * return IRequest Klasse
     *
     * @return IRequest
     */
    public function getRequest()
    {
        return $this->get(self::KEY_REQUEST);
    }

    /**
     * return IResponse Klasse
     *
     * @return IResponse
     */
    public function getResponse()
    {
        return $this->get(self::KEY_RESPONSE);
    }

    /**
     * return ISession Klasse
     *
     * @return SessionInterface
     */
    public function getSession()
    {
        return $this->get(self::KEY_SESSION);
    }

    public function getLogger()
    {
        return $this->get(self::KEY_LOGGER);
    }
}

?>