<?php

namespace Opf\Validator;


class NotEmpty extends ValidatorAbstract implements ValidatorInterface
{
    const STRING      = 0x001;
    const NULL        = 0x002;
    const EMPTY_ARRAY = 0x004;

    const NOT_EMPTY_STRING = 'notEmptyString';
    const NOT_EMPTY_NULL   = 'notEmptyNull';
    const NOT_EMPTY_ARRAY  = 'notEmptryArray';

    protected $options = array(
       'string' => false,
       'null'   => false,
       'array'  => false
    );

    protected $errorTemplates = array(
       self::NOT_EMPTY_STRING => 'The input is required and cannot be empty',
       self::NOT_EMPTY_NULL   => 'The input is required and cannot be empty',
       self::NOT_EMPTY_ARRAY  => 'The input is required and cannot be empty'
    );

    public function __construct($tests, array $errorTemplates = array())
    {
        if ($tests & self::STRING) {
            $this->testString();
        }

        if ($tests & self::NULL) {
            $this->testNull();
        }

        if ($tests & self::EMPTY_ARRAY) {
            $this->testArray();
        }

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function testString()
    {
        $this->options['string'] = true;
    }

    public function testNull()
    {
        $this->options['null'] = true;
    }

    public function testArray()
    {
        $this->options['array'] = true;
    }

    public function isValid($value)
    {
        if ($this->options['string']) {
            if (is_string($value) && $value === '') {
                $this->addError(self::NOT_EMPTY_STRING);
            }
        }

        if ($this->options['null']) {
            if ($value === null) {
                $this->addError(self::NOT_EMPTY_STRING);
            }
        }

        if ($this->options['array']) {
            if (is_array($value) && count($value) == 0) {
                $this->addError(self::NOT_EMPTY_STRING);
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
