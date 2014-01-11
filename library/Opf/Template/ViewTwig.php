<?php

namespace Opf\Template;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Twig_Loader_Filesystem;
use Twig_Environment;



class ViewTwig implements ViewInterface
{

    private $template;
    private $vars = array();
    private $helpers = array();

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function assign($name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function render(RequestInterface $request, ResponseInterface $response)
    {
        $loader = new Twig_Loader_Filesystem(OPF_APPLICATION_PATH . "/views/");
        $twig = new Twig_Environment($loader, array('debug'=> true));
        $twig->addExtension(new \Twig_Extension_Debug());
        $data = $twig->render("{$this->template}.twig", $this->vars);
        $response->write($data);
    }

    public function __get($property)
    {
        if (isset($this->vars[$property])) {
            return $this->vars[$property];
        }

        return null;
    }

    public function __call($methodName, $args)
    {
        $helper = $this->loadViewHelper($methodName);
        $val = $helper->execute($args);

        return $val;
    }

    protected function loadViewHelper($helper)
    {
        $helperName = ucfirst($helper);
        if (!isset($this->helpers[$helper])) {
            $className = "{$helperName}";
            $fileName = OPF_APPLICATION_PATH . "/views/helpers/{$className}.php";
            if (file_exists($fileName) === false) {
                throw new \Exception("File not found {$fileName}");
            }
            include_once $fileName;
            $this->helpers[$helper] = new $className();
        }

        return $this->helpers[$helper];
    }
}

