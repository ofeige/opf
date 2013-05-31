<?php

namespace Opf\Session;

interface SessionInterface
{
   public function issetParameter($name);

   public function getParameter($name);

   public function setParameter($name, $value);

   public function unsetParameter($name);
}

?>