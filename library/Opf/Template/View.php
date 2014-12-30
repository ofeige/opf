<?php

namespace Opf\Template;

use Opf\Bootstrap\Bootstrap;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class View implements ViewInterface
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
        ob_start();

        $uri = Bootstrap::getPathView() . "/{$this->template}.phtml";
        if (file_exists($uri) === false) {
            throw new \Exception("File not found " . $uri);
        }
        include_once($uri);

        $data = ob_get_clean();

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
        $val    = $helper->execute($args);

        return $val;
    }

    protected function loadViewHelper($helper)
    {
        $helperName = ucfirst($helper);
        if (!isset($this->helpers[$helper])) {
            $className = "{$helperName}";
            $fileName  = Bootstrap::getPathView() . "/helpers/{$className}.php";
            if (file_exists($fileName) === false) {
                throw new \Exception("File not found {$fileName}");
            }
            include_once $fileName;
            $this->helpers[$helper] = new $className();
        }

        return $this->helpers[$helper];
    }
}

?>
