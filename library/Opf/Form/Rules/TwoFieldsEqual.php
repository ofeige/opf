<?php
/**
 * Created by PhpStorm.
 * User: feige
 * Date: 01.02.14
 * Time: 17:40
 */

namespace Opf\Form\Rules;


use Opf\Form\RulesAbstract;
use Opf\Http\Request;


class TwoFieldsEqual extends RulesAbstract
{
    protected $nameSecondField = '';

    public function __construct($errorMsg, $nameSecondField)
    {
        $this->errorMsg        = $errorMsg;
        $this->nameSecondField = $nameSecondField;
    }

    public function isValid(Request $request)
    {
        if ($request->getParameter($this->name) == $request->getParameter($this->nameSecondField)) {
            return true;
        }

        return false;
    }
} 
