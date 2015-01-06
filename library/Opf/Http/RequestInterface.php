<?php

namespace Opf\Http;

interface RequestInterface
{
    public function getParameterNames();

    public function issetParameter($name);

    public function getParameter($name);

    public function getHeader($name);

    public function getAuthData();

    public function getRemoteAddress();

    public function getAllParameters();

    public function getUri();

    public function setParameter($name, $value);

    public function setParameterFromArray(array $values);

}
