<?php

namespace Opf\Template;

use Opf\Bootstrap\Bootstrap;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;


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
        $timing = microtime(true);

        $this->assign('cmd', $request->getParameter('cmd'));
        $this->assign('app', $request->getParameter('app'));

        $loader = new Twig_Loader_Filesystem(Bootstrap::getPathView());
        $twig = new Twig_Environment(
            $loader,
            array(
                'debug'         => true,
                'cache'         => Bootstrap::getPathCache(),
                'auto_reload'   => true,
                'optimizations' => -1
            )
        );
        $twig->addExtension(new \Twig_Extension_Debug());
        $data = $twig->render("{$this->template}.twig", $this->vars);

        $response->addHeader('X-OPF-TWIG-TIMING', microtime(true) - $timing);

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
            $fileName
                = Bootstrap::getPathView() . "/helpers/{$className}.php";
            if (file_exists($fileName) === false) {
                throw new \Exception("File not found {$fileName}");
            }
            include_once $fileName;
            $this->helpers[$helper] = new $className();
        }

        return $this->helpers[$helper];
    }
}

