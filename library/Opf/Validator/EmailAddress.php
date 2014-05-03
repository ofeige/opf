<?php

namespace Opf\Validator;


class EmailAddress extends ValidatorAbstract implements ValidatorInterface
{
    const EMAIL_ADDRESS = 'emailAddress';

    protected $options = array();

    protected $errorTemplates = array(
       self::EMAIL_ADDRESS => 'The input is not a valid email address'
    );

    public function __construct(array $errorTemplates = array())
    {
        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function isValid($value)
    {
        if ($value != '' && filter_var($value, FILTER_VALIDATE_EMAIL) == false) {
            $this->addError(self::EMAIL_ADDRESS);
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
