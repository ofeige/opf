<?php
/**
 * Created by PhpStorm.
 * User: feige
 * Date: 08.02.14
 * Time: 17:21
 */

namespace Opf\Form\Rules;


use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class EmailNotExists extends RulesAbstract
{
    protected $modelName;
    protected $fieldName;

    public function __construct($errorMsg, $modelName, $fieldName)
    {
        $this->errorMsg = $errorMsg;
        $this->modelName = $modelName;
        $this->fieldName = $fieldName;
    }

    public function isValid(Request $request)
    {
        $email = $request->getParameter($this->name);

        $user = \Model::factory($this->modelName)->where($this->fieldName, $email)->find_one();

        if ($user === false) {
            return true;
        }

        return false;
    }
} 