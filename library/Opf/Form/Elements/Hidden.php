<?php

namespace Opf\Form\Elements;

use Opf\Form\ElementAbstract;
use Opf\Form\ElementRenderInterface;

class Hidden extends ElementAbstract implements ElementRenderInterface
{
    public function __construct($name, $value)
    {
        $this->name  = $name;
        $this->value = $value;
    }


    public function __toString()
    {
        $error = '';
        if (count($this->errors) > 0) {
            $error = '<p class="help-block">' . implode('<br/>', $this->errors) . '</p>';
        }

        $html = '<input type="hidden" name="%s" value="%s">';

        return sprintf(
           $html,
           $this->name,
           $this->value
        );
    }
}