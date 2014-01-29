<?php
/**
 * Created by PhpStorm.
 * User: feige
 * Date: 28.01.14
 * Time: 22:22
 */

namespace Opf\Form\Elements;


use Opf\Form\ElementInterface;

class Button implements ElementInterface
{
    protected $label = '';

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function __toString()
    {
        $html = '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">%s</button>
    </div>
</div>';

        return sprintf($html, $this->label);
    }
} 