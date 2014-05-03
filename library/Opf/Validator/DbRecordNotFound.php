<?php
/**
 * Created by PhpStorm.
 * User: feige
 * Date: 02.05.14
 * Time: 00:25
 */

namespace Opf\Validator;


class DbRecordNotFound extends DbRecordAbstract implements ValidatorInterface
{
    public function isValid($value)
    {
        if (isset($this->options['exclude']['fieldName'])) {
            $result = \Model::factory($this->options['dbModel'])->where($this->options['field'], $value)
                            ->where_not_equal($this->options['exclude']['fieldName'],
                                              $this->options['exclude']['value'])->find_one();
        } else {
            $result = \Model::factory($this->options['dbModel'])->where($this->options['field'], $value)->find_one();
        }

        if ($result !== false) {
            $this->addError(self::DB_RECORD_FOUND);
        }

        if (count($this->errors) == 0) {
            return true;
        }

        return false;
    }
}
