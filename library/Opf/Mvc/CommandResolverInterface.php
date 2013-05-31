<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

interface CommandResolverInterface
{
   /**
    * Ermittelt das auszuführende Kommando und gibt die entsprechende ICommand Klasse zurück
    */
   public function getCommand(RequestInterface $request, ResponseInterface $response);
}

?>