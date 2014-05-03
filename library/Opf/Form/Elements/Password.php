<?php

namespace Opf\Form\Elements;

class Password extends ElementAbstract
{
    protected $name = '';
    protected $label = '';

    protected $rules = array();

    public function __construct($label, $placeholder = '')
    {
        $this->label       = $label;
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
        <input type="password" class="form-control" id="%s" name="%s" placeholder="%s" value="%s">%s
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
           $this->value,
           $error
        );
    }
}
