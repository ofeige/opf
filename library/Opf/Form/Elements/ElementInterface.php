<?php

namespace Opf\Form\Elements;


use Opf\Validator\ValidatorInterface;

interface ElementInterface
{
    public function __toString();

    public function isValid($value);

    public function setValue($value);

    public function getValue();

    public function setName($name);

    /**
     * @param ValidatorInterface $rule
     * @return ElementInterface
     */
    public function addRule(ValidatorInterface $rule);
} 
