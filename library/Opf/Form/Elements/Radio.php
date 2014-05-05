<?php

namespace Opf\Form\Elements;


class Radio extends ElementAbstract
{
    protected $options = array();

    public function __construct($label, array $options)
    {
        $this->label   = $label;
        $this->options = $options;
    }

    public function __toString()
    {
        $error = '';
        if (count($this->errors) > 0) {
            $error = '<p class="help-block">' . implode('<br/>', $this->errors) . '</p>';
        }

        $html = '<div class="radio">
  <label>
    <input type="radio" name="%s" value="%s"%s>
    %s
    </label>
</div>';

        $retVal = sprintf('<div class="form-group%s"><label class="col-sm-2 control-label">%s</label><div class="col-sm-10">',
           (count($this->errors) > 0 ? ' has-error' : ''),
                          $this->label);
        foreach ($this->options as $value => $label) {
            $retVal .= sprintf($html,
                               $this->name,
                               $value,
                               ($value == $this->value) ? ' checked="checked"' : '',
                               $label);
        }
        $retVal .= $error . '</div></div>';

        return $retVal;
    }
}
