<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

interface ControllerInterface
{
    public function __construct(CommandResolverInterface $resolver);

    public function handleRequest(RequestInterface $request, ResponseInterface $response);
}

?>
