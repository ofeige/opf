<?php

namespace Opf\Mvc;

interface CommandAuthInterface
{
   public function isSecure();
   public function getSecureRoles();
}