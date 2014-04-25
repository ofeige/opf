<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class Min extends RulesAbstract
{
    protected $min = 0;

    public function __construct($errorMsg, $min)
    {
        $this->errorMsg = $errorMsg;
        $this->min      = $min;
    }

    public function isValid(Request $request)
    {
        if ($request->getParameter($this->name) == '') {
            return true;
        }

        if (mb_strlen($request->getParameter($this->name)) >= $this->min) {
            return true;
        }

        return false;
    }
}
