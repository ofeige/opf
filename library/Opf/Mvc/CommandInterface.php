<?php

namespace Opf\Mvc;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

interface CommandInterface
{
    public function __construct(RequestInterface $request, ResponseInterface $response);

    public function main();

    public function getAcl();
}