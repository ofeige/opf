<?php

namespace Opf\Validator;


class FileUploadSize extends ValidatorAbstract implements ValidatorInterface
{
    const MAX_FILE_SIZE = 'maxFileSize';

    protected $options = array(
       'maxFileSize' => null // null = no max size
    );

    protected $errorTemplates = array(
       self::MAX_FILE_SIZE => 'uploaded file is to big, please use only %maxFileSize% Kb'
    );

    public function __construct($maxFileSize = null, array $errorTemplates = array())
    {
        $this->setMaxFileSize($maxFileSize);

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function setMaxFileSize($size)
    {
        $this->options['maxFileSize'] = $size;
    }

    public function isValid($value)
    {
        if (is_null($this->options['maxFileSize'])) {
            return true;
        }

        if (isset($value['error']) && $value['error'] == UPLOAD_ERR_FORM_SIZE) {
            $this->addError(self::MAX_FILE_SIZE);
        }

        if (isset($value['error']) && $value['error'] == UPLOAD_ERR_INI_SIZE) {
            $this->addError(self::MAX_FILE_SIZE);
        }


        if (isset($value['error']) && $value['error'] == UPLOAD_ERR_OK) {
            if ($value['size'] > ($this->options['maxFileSize'] * 1024)) {
                $this->addError(self::MAX_FILE_SIZE);
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
