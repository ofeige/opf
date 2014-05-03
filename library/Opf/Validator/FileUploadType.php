<?php

namespace Opf\Validator;


class FileUploadType extends ValidatorAbstract implements ValidatorInterface
{
    const FILE_TYPE = 'fileType';

    const FILE_UPLOAD_NOT_IMAGE = 'fileUploadNotImage';

    protected $options = array(
       'fileType' => null // null = all types allowed
    );

    protected $errorTemplates = array(
       self::FILE_TYPE => 'File Type is not allowed'
    );

    public function __construct(array $fileType = null, array $errorTemplates = array())
    {
        $this->setFileType($fileType);

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function setFileType($fileType)
    {
        $this->options['fileType'] = $fileType;
    }

    public function isValid($value)
    {
        if (is_null($this->options['fileType'])) {
            return true;
        }

        /** test only when there is a file uploaded */
        if (isset($value['error']) && $value['error'] == UPLOAD_ERR_OK) {
            $file = new \finfo(FILEINFO_MIME_TYPE);
            $info = $file->file($value['tmp_name']);

            if (in_array($info, $this->options['fileType']) == false) {
                $this->addError(self::FILE_TYPE);
            }
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
