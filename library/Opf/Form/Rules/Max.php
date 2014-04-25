<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class Max extends RulesAbstract
{
    protected $max = 0;

    public function __construct($errorMsg, $max)
    {
        $this->errorMsg = $errorMsg;
        $this->max      = $max;
    }

    public function isValid(Request $request)
    {
        if (mb_strlen($request->getParameter($this->name)) <= $this->max) {
            return true;
        }

        return false;
    }
} 
