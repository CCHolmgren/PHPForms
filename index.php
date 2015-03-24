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
require_once(__SITEROOT__ . '/src/PHPForms/Forms/FormBuilder.php');
require_once(__SITEROOT__ . '/src/PHPForms/Forms/Form.php');
require_once(__SITEROOT__ . '/src/PHPForms/Fields/FormField.php');
function __autoload($name){
    echo $name;
    include __SITEROOT__ . '/src/' . $name . '.php';
}
use PHPForms\Forms\FormBuilder;

$form = new FormBuilder();
$form->addField(
        new \PHPForms\Fields\FormField('test', 'text', ['value' => 'Hello there']))
    ->addButton('Submit', ['onclick' => 'alert("test")'])
    ->addField(new \PhpForms\Fields\ButtonField('', 'button'))
    ->addField(
        new \PHPForms\Fields\FormField('test', 'text', ['value' => 'Hello there']));
echo $form->form()->asParagraph();
?>
</body>
</html>
