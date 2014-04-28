<?php

namespace Opf\Form\Rules;

use Opf\Form\RulesAbstract;
use Opf\Http\Request;

class FileUploadType extends RulesAbstract
{
    public $type;

    public function __construct($errorMsg, $type = false)
    {
        $this->errorMsg = $errorMsg;
        $this->type     = $type;
    }

    public function isValid(Request $request)
    {
        /** ok when there is no file */
        if (isset($_FILES[$this->name]) && $_FILES[$this->name]['error'] == UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (isset($_FILES[$this->name]) && $_FILES[$this->name]['error'] == UPLOAD_ERR_OK) {

            /** test all possible images was compiled into php */
            if ($this->type === false) {
                $str = file_get_contents($_FILES[$this->name]['tmp_name']);
                $img = \imagecreatefromstring($str);

                if ($img !== false) {
                    return true;
                }
            } /** test only given filetypes */
            else {
                $info = getimagesize($_FILES[$this->name]['tmp_name']);

                if (in_array($info[2], $this->type)) {
                    return true;
                }
            }
        }

        return false;
    }
}
