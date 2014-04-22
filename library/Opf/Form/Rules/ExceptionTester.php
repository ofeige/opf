<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class ExceptionTester extends RulesAbstract
{
    public $callBack;

    public function __construct($errorMsg, $callBack)
    {
        $this->errorMsg = $errorMsg;
        $this->callBack = $callBack;
    }

    public function isValid(Request $request)
    {
        $cb = $this->callBack;

        try {
            call_user_func($cb, $request->getParameter($this->name));

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
} 