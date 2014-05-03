<?php

namespace Opf\Validator;


class StringLength extends ValidatorAbstract implements ValidatorInterface
{
    const TO_LONG  = 'stringLengthToLong';
    const TO_SHORT = 'stringLengthToShort';

    protected $options = array(
       'maxStringLength' => null,
       'minStringLength' => 0
    );

    protected $errorTemplates = array(
       self::TO_LONG  => 'The input is more than %maxStringLength% characters long',
       self::TO_SHORT => 'The input is lesser than %minStringLength% characters long'
    );

    public function __construct($max = null, $min = null, array $errorTemplates = array())
    {
        $this->setMax($max);

        if ($min !== null) {
            $this->setMin($min);
        }

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function setMax($max)
    {
        $this->options['maxStringLength'] = $max;
    }

    public function setMin($min)
    {
        $this->options['minStringLength'] = $min;
    }

    public function isValid($value)
    {
        if (is_integer($this->options['maxStringLength']) && mb_strlen($value) > $this->options['maxStringLength']) {
            $this->addError(self::TO_LONG);
        }

        /** check only the minimum string length, when a string has been entered */
        if (mb_strlen($value) > 0) {
            if (is_integer($this->options['minStringLength']) && mb_strlen($value) < $this->options['minStringLength']) {
                $this->addError(self::TO_SHORT);
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
