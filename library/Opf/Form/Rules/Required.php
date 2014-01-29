<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class Required extends RulesAbstract
{

    public function __construct($errorMsg)
    {
        $this->errorMsg = $errorMsg;
    }

    public function isValid(Request $request)
    {
        if (mb_strlen($request->getParameter($this->name)) > 0) {
            return true;
        }

        return false;
    }
} 