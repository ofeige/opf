<?php
namespace Opf\Template;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

interface ViewInterface {
    public function assign($name, $value);
    public function render(RequestInterface $request, ResponseInterface $response);
}
?>