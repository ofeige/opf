<?php

namespace Opf\Bootstrap;


use Opf\Auth\AuthEventHandler;
use Opf\Auth\Driver\Mysql;
use Opf\Event\Dispatcher;
use Opf\Http\Request;
use Opf\Http\Response;
use Opf\Mvc\CommandResolver;
use Opf\Mvc\Controller;
use Opf\Route\Route;
use Opf\Route\Router;
use Opf\Route\RouteStatic;
use Opf\Session\Php;
use Opf\Template\ViewTwig;

class Bootstrap
{
    protected static $pathPublic = NULL;
    protected static $pathView = NULL;
    protected static $pathApp = NULL;
    protected static $pathCache = NULL;

    const PATH_APP = 'path_app';
    const PATH_CACHE = 'path_cache';
    const PATH_VIEW = 'path_view';
    const PATH_PUBLIC = 'path_public';

    const KEY_REQUEST = 'request';
    const KEY_RESPONSE = 'response';
    const KEY_SESSION = 'session';
    const KEY_LOGGER = 'logger';

    protected static $instance = null;
    protected $values = array();
    protected $router;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Bootstrap();
        }

        return self::$instance;
    }

    public function setPathApp($path)
    {
        if (file_exists($path) == false) {
            throw new \Exception('Base Application Path is wrong');
        }

        self::$pathApp = $path;

        chdir($path);

        return $this;
    }


    public function setConfig(array $config)
    {
        if (isset($config['path_cache'])) {
            self::$pathCache = $config['path_cache'];
        }

        if (isset($config['path_public'])) {
            self::$pathPublic = $config['path_public'];
        }

        if (isset($config['path_view'])) {
            self::$pathView = $config['path_view'];
        }

        return $this;
    }

    public function setDefaultConfig()
    {
        if (isset(self::$pathPublic) == false) {
            self::$pathPublic = self::$pathApp . '/../public';
        }

        if (isset(self::$pathView) == false) {
            self::$pathView = self::$pathApp . '/views';
        }

        if (isset(self::$pathCache) == false) {
            self::$pathCache = self::$pathApp . '/../data/cache';
        }

        if (isset($this->values[self::KEY_REQUEST]) == false) {
            $this->set(self::KEY_REQUEST, new Request());
        }

        if (isset($this->values[self::KEY_RESPONSE]) == false) {
            $this->set(self::KEY_RESPONSE, new Response());
        }

        if (isset($this->values[self::KEY_SESSION]) == false) {
            $this->set(self::KEY_SESSION, new Php());
        }
    }


    public function setRequest(RequestInterface $request)
    {
        $this->set(self::KEY_REQUEST, $request);

        return $this;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->set(self::KEY_RESPONSE, $response);

        return $this;
    }

    public function setSession(SessionInterface $session)
    {
        $this->set(self::KEY_SESSION, $session);
    }

    public function getSession()
    {
        return $this->get(self::KEY_SESSION);
    }

    public function getRequest()
    {
        return $this->get(self::KEY_REQUEST);
    }

    public function getResponse()
    {
        return $this->get(self::KEY_RESPONSE);
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


    public function setupAuth()
    {
        $driver = new Mysql('User');
        $login = new ViewTwig('signin');
        $auth = new AuthEventHandler($driver, $this->getSession(), $this->getRequest(), $this->getResponse(), $login);

        return $auth;
    }

    public function setupMvc()
    {
        $resolver = new CommandResolver(self::$pathApp, 'index');
        $controller = new Controller($resolver);
        $controller->addPreFilter($this->getRoutes());
        $controller->handleRequest($this->getRequest(), $this->getResponse());
    }

    public function setRoutes(Router $router)
    {
        $this->router = $router;
    }

    public function getRoutes()
    {
        return $this->router;
    }

    public function run()
    {
        $this->setDefaultConfig();

        try {
            $auth = $this->setupAuth();
            Dispatcher::getInstance()->addHandler('CommandConstructor', $auth);
            $this->setupMvc();

        }
        catch (\Exception $e) {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
        }
    }



    public static function getPathPublic()
    {
        return self::$pathPublic;
    }

    public static function getPathApp()
    {
        return self::$pathApp;
    }

    public static function getPathView()
    {
        return self::$pathView;
    }
    public static function getPathCache()
    {
        return self::$pathCache;
    }

    private function __clone()
    {
    }
}
