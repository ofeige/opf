<?php

namespace Opf\Session;

interface SessionInterface
{
    public function start($lifetime);

    public function destroy();

    public function setLifetime($lifetime);

    public function issetParameter($name);

    public function getParameter($name);

    public function setParameter($name, $value);

    public function unsetParameter($name);
}

?>
