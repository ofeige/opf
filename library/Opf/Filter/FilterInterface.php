<?php

namespace Opf\Filter;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

interface FilterInterface
{
    public function execute(RequestInterface $request, ResponseInterface $response);
}

?>
