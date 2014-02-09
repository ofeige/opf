<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class CommandResolver implements CommandResolverInterface
{
   private $path;
   private $defaultCommand;

   public function __construct($path, $defaultCommand)
   {
      $this->path = $path;
      $this->defaultCommand = $defaultCommand;
   }

   /**
    * Ermittelt das auszuführende Kommando und gibt eine OICommand Klasse zurück
    *
    * @param RequestInterface $request
    * @param ResponseInterface $response
    * @return CommandInterface
    */
   public function getCommand(RequestInterface $request, ResponseInterface $response)
   {
      $cmdName = $this->defaultCommand;
      if ($request->issetParameter('app') === true) {
         $cmdName = $request->getParameter('app');
      }

      $className = 'Opf\Mvc\\'.$this->loadCommand($cmdName);

      return new $className($request, $response);
   }

   protected function loadCommand($cmdName)
   {
      $class = $cmdName;
      $file = $this->path . '/commands/' . $cmdName . '.php';

      include_once($file);

      return $class;
   }
}
