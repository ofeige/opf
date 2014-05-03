<?php

namespace Opf\Form\Elements;


use Opf\Validator\FileUploadSize;

class FileUpload extends ElementAbstract
{
    protected $label = '';

    public function __construct($label, $maxFileSize = null)
    {
        $this->label = $label;

        if ($maxFileSize) {
            $this->addRule(new FileUploadSize($maxFileSize));
            $this->maxFileSize = $maxFileSize;
        }
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
                       $this->maxFileSize * 1024,
                       $this->name,
                       $error
        );
    }
}
