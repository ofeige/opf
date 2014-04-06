<?php

namespace Opf\Form;

use Opf\Http\Request;

class Form
{
    private $elements = array();


    /**
     * @param ElementRenderInterface $element
     * @return ElementRenderInterface
     */
    public function addElement(ElementRenderInterface $element)
    {
        $this->elements[] = $element;

        return $element;
    }

    /**
     * @param Request $request
     * @param array $values
     */
    public function setInitValues(Request $request, array $values)
    {
        if($request->getParameter('isSend') != true) {
            foreach ($this->elements as $element) {
                if (in_array('Opf\Form\ElementInputInterface', class_implements($element)) === false) {
                    continue;
                }

                if(array_key_exists($element->getName(), $values)) {
                    $element->setValue($values[$element->getName()]);
                }

            }
        }
    }

    public function isValid(Request $request)
    {
        $retval = true;

        if ($request->getParameter('isSend') != true) {
            return false;
        }

        foreach ($this->elements as $element) {
            if (in_array('Opf\Form\ElementInputInterface', class_implements($element)) === false) {
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
            if (in_array('Opf\Form\ElementInputInterface', class_implements($element)) === false) {
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