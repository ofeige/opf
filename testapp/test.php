<?php

require('../library/Opf/Http/RequestInterface.php');
require('../library/Opf/Http/Request.php');

require('../library/Opf/Form/FormElementAbstract.php');
require('../library/Opf/Form/ElementInterface.php');
require('../library/Opf/Form/Form.php');
require('../library/Opf/Form/Elements/Input.php');
require('../library/Opf/Form/Rules/Required.php');





$input = new Input('user', 'Benutzername', 'bitte geben Sie Ihren Benutzernamen ein');
$input->setRequired('Bitte Usernamen angeben');

$form = new Form();
$form->addElement($input);


var_dump($form->isValid(new \Opf\Http\Request()));

echo $form."\n";