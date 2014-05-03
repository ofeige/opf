<?php

namespace Opf\Validator;

interface ValidatorInterface
{

    public function getErrors();

    public function isValid($value);
}
