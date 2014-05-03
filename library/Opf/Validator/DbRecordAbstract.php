<?php

namespace Opf\Validator;


use Opf\Exception\WrongParameterException;

class DbRecordAbstract extends ValidatorAbstract
{
    const DB_RECORD_FOUND     = 'dbRecordFound';
    const DB_RECORD_NOT_FOUND = 'dbRecordNotFound';

    protected $options = array(
       'dbModel' => false,
       'field'   => false,
       'exclude' => array()
    );

    protected $errorTemplates = array(
       self::DB_RECORD_FOUND     => 'A record matching the input was found',
       self::DB_RECORD_NOT_FOUND => 'No record matching the input was found'
    );

    public function __construct($dbModel, $field, array $exclude = array(), array $errorTemplates = array())
    {
        $this->setDbModel($dbModel);
        $this->setField($field);
        $this->setExclude($exclude);

        if (count($errorTemplates) > 0) {
            $this->errorTemplates = array_merge($this->errorTemplates, $errorTemplates);
        }
    }

    public function setDbModel($dbModel)
    {
        $this->options['dbModel'] = $dbModel;
    }

    public function setField($field)
    {
        $this->options['field'] = $field;
    }

    public function setExclude(array $exclude)
    {
        if (count($exclude) > 0) {
            if (isset($exclude['fieldName']) == false) {
                throw new WrongParameterException('Parameter "fieldName" not set');
            }

            if (isset($exclude['value']) == false) {
                throw new WrongParameterException('Parameter "value" not set');
            }

            $this->options['exclude'] = $exclude;
        }
    }
}
