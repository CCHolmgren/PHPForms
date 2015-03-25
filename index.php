<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 10:00
 */
define('__SITEROOT__', realpath(dirname(__FILE__)));
//require_once(__SITEROOT__ . '/src/PHPForms/Forms/FormBuilder.php');
//require_once(__SITEROOT__ . '/src/PHPForms/Forms/Forms.php');
//require_once(__SITEROOT__ . '/src/PHPForms/Fields/FormField.php');
function __autoload($name){
    echo $name;
    include __SITEROOT__ . '/src/' . $name . '.php';
}
use PHPForms\Forms\FormBuilder;
use PHPForms\Fields\FormField;
use PHPForms\Fields\ButtonField;
use PHPForms\Fields\ButtonButtonField;
use PHPForms\Fields\PasswordField;
use PHPForms\Fields\TextareaField;

$form = new FormBuilder();
//The fields are instantiated with the values $name, $type, $options
//Text that should appear under value, is placed under $options['value'] and so on
//Attrbutes are placed under $options['attributes'] and css - classes $options['classes']
$form->addField(
        new FormField('test', 'text'))
    ->addButton('Submit', ['onclick' => 'alert("test")', 'style'=>'border:10px solid black;'])
    ->addField(new ButtonField('', 'button', ['value'=>'Empty click']))
    ->addField(new ButtonButtonField('', '',['value'=>'Hello there']))
    ->addField(new PasswordField('password'))
    ->addField(new ButtonField('', 'submit', ['value'=>'Another one']))
    ->addField(new TextareaField('test-name', '', ['value'=>'Hello the textarea']))
    ->addField(new FormField('test', 'text'));

echo $form->form->asParagraph();

$form->addData(['test' => 'Hello there from newly added data', 'password' => 'This is my super secret password']);
echo $form->form->asUnorderedList();
echo $form->form->asTable();
?>
</body>
</html>
