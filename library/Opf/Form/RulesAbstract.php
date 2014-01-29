<?php

namespace Opf\Form;


abstract class RulesAbstract
{
    protected $name = '';
    protected $errorMsg = '';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}