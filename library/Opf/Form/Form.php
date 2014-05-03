<?php

namespace Opf\Form;

use Opf\Exception\FormGenerationException;
use Opf\Form\Elements\ElementInterface;

class Form
{
    protected $elements = array();
    protected $data = array();

    public function addElement($name, ElementInterface $element)
    {
        if (isset($this->elements[$name])) {
            throw new FormGenerationException("Element with name $name is already used");
        }

        $element->setName($name);
        $this->elements[$name] = $element;

        return $element;
    }

    /**
     * @param $name                    String with the searched element name
     * @return ElementInterface        Return the searched element
     * @throws FormGenerationException
     */
    public function getElement($name)
    {
        if (isset($this->elements[$name]) == false) {
            throw new FormGenerationException("Element with name $name not found");
        }

        return $this->elements[$name];
    }

    /**
     * @param array $data the POST or GET Data with the user input
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set default values to the form, only when the form ist not posted
     * @param array $values
     */
    public function setInitValues(array $values)
    {
        if (isset($this->data['isSend']) == false || $this->data['isSend'] != true) {
            foreach ($this->elements as $name => $element) {
                if ($element instanceof ElementInterface) {
                    if (array_key_exists($name, $values)) {
                        $element->setValue($values[$name]);
                    }
                }
            }
        }
    }

    public function isValid()
    {
        $retVal = true;

        if (isset($this->data['isSend']) == false || $this->data['isSend'] != true) {
            return false;
        }

        foreach ($this->elements as $name => $element) {
            if ($element instanceof ElementInterface) {
                if (isset($this->data[$name]) && $element->isValid($this->data[$name]) == false) {
                    $retVal = false;
                }
            }
        }

        return $retVal;
    }

    public function getData()
    {
        $data = array();

        foreach ($this->elements as $name => $element) {
            if ($element instanceof ElementInterface) {
                $data[$name] = $element->getValue();
            }
        }

        return $data;
    }

    public function __toString()
    {
        $str = '<form enctype="multipart/form-data" class="form-horizontal" role="form" method="post" action=""><input type="hidden" name="isSend" value="true">';

        foreach ($this->elements as $element) {
            $str .= $element;
        }

        $str .= '</form>';

        return $str;
    }
}
