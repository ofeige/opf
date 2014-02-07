<?php

namespace Opf\Form;

use Composer\DependencyResolver\Rule;

abstract class ElementAbstract
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

    public function addRule(RulesAbstract $rule)
    {
        $rule->setName($this->name);
        $this->rules[] = $rule;

        return $this;
    }

    public function isValid(\Opf\Http\Request $request)
    {
        $this->value = $request->getParameter($this->name);

        $isValid = true;
        foreach ($this->rules as $rule) {
            if ($rule->isValid($request) === false) {
                $isValid = false;
                $this->errors[] = $rule->getErrorMsg();
            }
        }

        return $isValid;
    }
}