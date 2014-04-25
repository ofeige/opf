<?php

namespace Opf\Form;

interface ElementInputInterface
{
    public function getName();

    public function getValue();

    /**
     * @param string $param
     * @return ElementInputInterface
     */
    public function setRequired($param);

    /**
     * @param RulesAbstract $rule
     * @return ElementInputInterface
     */
    public function addRule(RulesAbstract $rule);

    /**
     * @param \Opf\Http\Request $request
     * @return boolean
     */
    public function isValid(\Opf\Http\Request $request);
}
