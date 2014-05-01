<?php

namespace Opf\Form\Elements;


use Opf\Form\ElementAbstract;
use Opf\Form\ElementRenderInterface;

class FileUpload extends ElementAbstract implements ElementRenderInterface
{
    protected $label = '';

    public function __construct($label, $name, $maxFileSize)
    {
        $this->name        = $name;
        $this->label       = $label;
        $this->maxFileSize = $maxFileSize;
    }

    public function isValid(\Opf\Http\Request $request)
    {
        if (isset($_FILES[$this->name])) {
            $this->value = $_FILES[$this->name];
        }

        $isValid = true;
        foreach ($this->rules as $rule) {
            if ($rule->isValid($request) === false) {
                $isValid        = false;
                $this->errors[] = $rule->getErrorMsg();
            }
        }

        return $isValid;
    }

    public function __toString()
    {
        $error = '';
        if (count($this->errors) > 0) {
            $error = '<p class="help-block">' . implode('<br/>', $this->errors) . '</p>';
        }

        $html = '
<div class="form-group">
    <label for="%s" class="col-sm-2 control-label">%s</label>
    <div class="col-sm-10">
        <input type="hidden" name="MAX_FILE_SIZE" value="%s" /><input name="%s" type="file" />%s
    </div>
</div>';

        return sprintf($html,
                       $this->name,
                       $this->label,
                       $this->maxFileSize,
                       $this->name,
                       $error
        );
    }
}
