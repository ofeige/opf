<?php

    namespace Opf\Form\Elements;


    use Opf\Form\ElementAbstract;
    use Opf\Form\ElementInterface;

    class Button extends ElementAbstract implements ElementInterface
    {
        protected $label = '';

        public function __construct($name, $label, $value)
        {
            $this->name  = $name;
            $this->label = $label;
            $this->value = $value;
        }

        public function __toString()
        {
            $html = '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary" name="%s" value="%s">%s</button>
    </div>
</div>';

            return sprintf($html, $this->name, $this->value, $this->label);
        }
    }