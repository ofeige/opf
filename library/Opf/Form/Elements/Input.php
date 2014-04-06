<?php

namespace Opf\Form\Elements;

use Opf\Form\ElementAbstract;
use Opf\Form\ElementInputInterface;
use Opf\Form\ElementRenderInterface;
use Opf\Form\Rules\Required;

class Input extends ElementAbstract implements ElementRenderInterface, ElementInputInterface
{
    protected $label = '';

    protected $rules = array();

    public function __construct($name, $label, $placeholder='')
    {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    public function __toString()
    {
        $error = '';
        if (count($this->errors) > 0) {
            $error = '<p class="help-block">' . implode('<br/>', $this->errors) . '</p>';
        }

        $html = '<div class="form-group%s">
    <label for="%s" class="col-sm-2 control-label">%s</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="%s" name="%s" placeholder="%s" value="%s">%s
    </div>
</div>';

        return sprintf(
           $html,
           (count($this->errors) > 0 ? ' has-error' : ''),
           $this->name,
           $this->label,
           $this->name,
           $this->name,
           $this->placeholder,
           htmlspecialchars($this->value),
           $error
        );
    }
}