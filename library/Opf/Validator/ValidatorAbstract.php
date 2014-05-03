<?php
/**
 * Created by PhpStorm.
 * User: feige
 * Date: 02.05.14
 * Time: 02:36
 */

namespace Opf\Validator;


abstract class ValidatorAbstract
{
    protected $errors = array();
    protected $errorTemplates = array();
    protected $options = array();

    protected function addError($type)
    {
        $this->errors[$type] = $type;
    }

    public function getErrors()
    {
        $retVal = array();

        foreach ($this->errors as $error) {
            $errorString = $this->errorTemplates[$error];
            foreach ($this->options as $key => $option) {
                if (is_array($option)) {
                    continue;
                }
                $errorString = str_replace("%$key%", $option, $errorString);
            }
            $retVal[] = $errorString;
        }

        return $retVal;
    }
}
