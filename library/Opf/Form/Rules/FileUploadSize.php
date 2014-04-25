<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class FileUploadSize extends RulesAbstract
{
    public $size;

    public function __construct($errorMsg, $size)
    {
        $this->errorMsg = $errorMsg;
        $this->size     = $size;
    }

    public function isValid(Request $request)
    {
        /** ok when there is no file */
        if (isset($_FILES[$this->name]) && $_FILES[$this->name]['error'] !== UPLOAD_ERR_OK) {
            return true;
        }

        /**  */
        if (isset($_FILES[$this->name]) && $_FILES[$this->name]['error'] == UPLOAD_ERR_OK && $_FILES[$this->name]['size'] <= $this->size && $_FILES[$this->name]['error'] == 0) {
            return true;
        }


        return false;
    }
}
