<?php

namespace Opf\Form\Elements;

class Hidden extends ElementAbstract
{
    public function __construct($value)
    {
        $this->value = $value;
    }


    public function __toString()
    {
        $html = '<input type="hidden" name="%s" value="%s">';

        return sprintf(
           $html,
           $this->name,
           $this->value
        );
    }
}
