<?php

namespace Opf\Validator;


class IsEqualTo extends ValidatorAbstract implements ValidatorInterface
{
    const IS_EQUAL_TO = 'isEqualTo';

    protected $options = array(
       'secondField' => false
    );

    protected $errorTemplates = array(
       self::IS_EQUAL_TO => 'The input is not equal to %secondField%'
    );

    protected $context = false;

    public function __construct($secondField, array $context, array $errorTemplates = array())
    {
        $this->setSecondField($secondField);
        $this->context = $context;

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function setSecondField($secondField)
    {
        $this->options['secondField'] = $secondField;
    }

    public function isValid($value)
    {
        if ($this->options['secondField'] !== false) {
            if ($this->context[$this->options['secondField']] != $value) {
                $this->addError(self::IS_EQUAL_TO);
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
