<?php

namespace Opf\Form\Elements;


use Opf\Form\ElementAbstract;
use Opf\Form\ElementRenderInterface;

class Button implements ElementRenderInterface
{
    protected $label = '';

    public function __construct($label, $name = '', $value = '')
    {
        $this->name  = $name;
        $this->label = $label;
        $this->value = $value;
    }

    public function __toString()
    {
        if ($this->name == '') {
            $btn = sprintf('<button type="submit" class="btn btn-primary">%s</button>', $this->label);
        } else {
            $btn = sprintf(
               '<button type="submit" class="btn btn-primary" name="%s" value="%s">%s</button>',
               $this->name,
               $this->value,
               $this->label
            );
        }

        $html = '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">%s</div>
</div>';

        return sprintf($html, $btn);
    }
}