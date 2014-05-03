<?php

namespace Opf\Form\Elements;

use Opf\Validator\ValidatorInterface;

abstract class ElementAbstract implements ElementInterface
{
    protected $rules = array();
    protected $errors = array();
    protected $name = '';
    protected $value = '';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function addRule(ValidatorInterface $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function isValid($value)
    {
        $this->value = $value;

        $isValid = true;
        foreach ($this->rules as $rule) {
            if ($rule instanceof ValidatorInterface) {
                if ($rule->isValid($value) === false) {
                    $isValid = false;

                    foreach ($rule->getErrors() as $error) {
                        $this->errors[] = $error;
                    }
                }
            }
        }

        return $isValid;
    }
}
