<?php

namespace Opf\Form\Elements;

use Opf\Form\ElementAbstract;
use Opf\Form\ElementInterface;

class Hidden extends ElementAbstract implements ElementInterface
{
    public function __construct($name)
    {
        $this->name = $name;
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