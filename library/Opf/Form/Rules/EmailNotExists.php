<?php

namespace Opf\Form\Rules;


use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class EmailNotExists extends RulesAbstract
{
    protected $modelName;
    protected $fieldName;
    protected $exceptionValue;

    public function __construct($errorMsg, $modelName, $fieldName, $exceptionValue = false)
    {
        $this->errorMsg       = $errorMsg;
        $this->modelName      = $modelName;
        $this->fieldName      = $fieldName;
        $this->exceptionValue = $exceptionValue;
    }

    public function isValid(Request $request)
    {
        $email = $request->getParameter($this->name);

        if ($this->exceptionValue !== false && $this->exceptionValue == $email) {
            return true;
        }

        $user = \Model::factory($this->modelName)->where($this->fieldName, $email)->find_one();

        if ($user === false) {
            return true;
        }

        return false;
    }
} 
