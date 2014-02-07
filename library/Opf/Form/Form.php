<?php

namespace Opf\Form;

use Opf\Http\Request;

class Form
{
    private $elements = array();

    public function __construct()
    {

    }

    public function addElement($element)
    {
        $this->elements[] = $element;
        return $element;
    }

    public function isValid(\Opf\Http\Request $request)
    {
        $retval = true;

        if ($request->getParameter('isSend') != true) {
            return false;
        }

        foreach ($this->elements as $element) {
            if (in_array('Opf\Form\ElementAbstract', class_parents($element)) === false) {
                continue;
            }

            if ($element->isValid($request) == false) {
                $retval = false;
            }
        }

        return $retval;
    }

    public function getData()
    {
        $data = array();

        foreach ($this->elements as $element) {
            if (in_array('Opf\Form\ElementAbstract', class_parents($element)) === false) {
                continue;
            }

            $data[$element->getName()] = $element->getValue();
        }

        return $data;
    }

    public function __toString()
    {
        $str = '<form class="form-horizontal" role="form" method="post" action=""><input type="hidden" name="isSend" value="true">';

        foreach ($this->elements as $element) {
            $str .= $element;
        }

        $str .= '</form>';

        return $str;
    }
}