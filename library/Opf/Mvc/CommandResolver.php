<?php

namespace Opf\Mvc;

use Opf\Exception\FileNotFoundException;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class CommandResolver implements CommandResolverInterface
{
    private $path;
    private $defaultCommand;

    public function __construct($path, $defaultCommand)
    {
        $this->path           = $path;
        $this->defaultCommand = $defaultCommand;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed
     * @throws ClassNotFoundException
     */
    public function getCommand(RequestInterface $request, ResponseInterface $response)
    {
        $cmdName = $this->defaultCommand;
        if ($request->issetParameter('app') === true) {
            $cmdName = $request->getParameter('app');
        }

        $className = 'Opf\Mvc\\' . $this->loadCommand($cmdName);

        if (class_exists($className) == false) {
            throw new ClassNotFoundException('Class "' . $className . '" not found', 404);
        }

        return new $className($request, $response);
    }

    protected function loadCommand($cmdName)
    {
        $class = $cmdName;
        $file  = $this->path . '/commands/' . $cmdName . '.php';

        if (!file_exists($file)) {
            throw new FileNotFoundException('File "' . $file . '" not found', 404);
        }

        include_once($file);

        return $class;
    }
}
