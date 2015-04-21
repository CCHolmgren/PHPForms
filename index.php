<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

// Version 0.3.0
require 'vendor/autoload.php';

use PHPForms\Fields\ButtonButtonField;
use PHPForms\Fields\ButtonField;
use PHPForms\Fields\FormField;
use PHPForms\Fields\LegendField;
use PHPForms\Fields\PasswordField;
use PHPForms\Fields\TextareaField;
use PHPForms\Forms\FormBuilder;
use PHPForms\Forms\Forms;
use PHPForms\Validators\Validator;

/*
 * A simple class-based validator that implements the Validator interface
 * This class does not do anything difficult, so we could just use a function based validator here
 */

class ValidatorYes implements Validator {
    public function validate($value) {
        echo "Validate called with some odd value:  $value";

        return "This is not right!";
    }
}

/*
 * Inheriting from Forms allows you to use it as LFB does
 */

class PostForm extends Forms {
    public function buildForm() {
        $this
            ->add('text', 'name', ['classes' => ['form-control']])
            ->add('textarea', 'lyrics')
            ->add('checkbox', 'publish')
            ->addButton('Submit');

        return $this;
    }
}

$x = new PostForm();
//echo $x->buildForm()->asDivs('form-group');

echo "<hr>";

$fieldset = new \PHPForms\Fields\FieldsetField();
$fieldset->addField(new LegendField('', '', ['value' => 'Testing, testing']));
$fieldset->addField(new ButtonField('', 'button', ['value' => 'Empty click']));

$select = new \PHPForms\Fields\SelectField();
$select->addField(new \PHPForms\Fields\OptionField('', '', ['value' => '1', 'text' => 'My text']));
$select->addField(new \PHPForms\Fields\OptionField('', '', ['value' => '2', 'text' => 'Some other text']));

$formbuilder = new FormBuilder();

// The fields are instantiated with the values $name, $type, $options
// Text that should appear under value, is placed under $options['value'] and so on
// Attributes are placed under $options['attributes'] and css - classes $options['classes']

$formbuilder->addField(
    new FormField('test', 'number', ['value' => "4", 'validators' => [
        new \PHPForms\Validators\ValueRangeValidator(1, 3, "Value must be between 1 and 3"),
        new \PHPForms\Validators\MaxValueValidator(5, "Value must be at most 5."),
        new \PHPForms\Validators\RegexValidator('/3/', "Must not be 3", true),
        new \PHPForms\Validators\RegexValidator('/2/', "Must be 2", false),
    ]]))
        // A lot of validators. Displaying Classbased validation and also method validation. This of course works if you pass a string to a method as well
            ->addButton('Submit',
                        ['onclick' => 'alert("test")', 'style' => 'border:10px solid black;'])// A button added by the helper addButton, this will always create a submit button. Displaying setting onclick of the button, and also style
            ->addField(new ButtonField('', 'button',
                                       ['value' => 'Empty click', 'label' => ['wrap' => true, 'value' => 'This is my label']]))// Button that is wrapped by a label with the text 'This is my label'
            ->addField(new ButtonButtonField('', '', ['value' => 'Hello there']))
            ->addField(new PasswordField('password'))
            ->addField(new ButtonField('', 'submit', ['value' => 'Another one']))
            ->add('Button', '', ['value'=>'Button'])// Generic add method. This tries to create a field with the class ButtonField
            ->add('Password', 'password_one_two_three')// Generic add method. This tries to create a field with the class PasswordField, name = '', and type = '' since it doesn't care about type
            ->addField(new TextareaField('test-name', '',
                                         ['value' => 'Hello the textarea']))// Textarea with name test-name, and the type doesn't matter. The text that will be in the textarea is given by 'value'=>'Hello the textarea'
            ->addField(new FormField('someothername',
                                     'text'))// FormField is a generic field, so the element will be a <input name='someothername' type='text'> in this case
            ->addField($select)// Adding already created elements
            ->addField($fieldset); // Adding a fieldset, that is already created

//echo $formbuilder->form->asParagraph();
echo "<hr>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formbuilder->addData($_POST);
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //$formbuilder->addData($_GET);
}

//echo $formbuilder->form->asUnorderedList();

echo "<hr>";

$formbuilder->form->setMethod('POST');
//echo $formbuilder->form->asTable();

echo "<hr>";

var_dump($formbuilder->form->getErrors());

if ($formbuilder->form->isValid()) {
    echo "The form is valid";
} else {
    echo "The form is not valid";
}
$test = new FormBuilder();

$test->addField(new TextareaField('test-name-what'));
$formbuilder->form->addNested($test->form, 'test');

//echo $formbuilder->form->asDivs();

echo "<hr>";

$login_form = new Forms();
//$login_form->add('text', 'username')
//->add('password', 'password')
//->addButton('Submit');
//echo $login_form->asDivs();

$register_form = new Forms();
$register_form->add('text', 'username', ['label'=>['value'=>'Username', 'for'=>'username']])
    ->add('repeatedpassword')
//->add('password', 'password', ['label'=>['value'=>'Password'], 'attributes'=>['placeholder'=>'Password']])
//->add('password', 'password_confirmation', ['label'=>['value'=>'Confirm password'], 'attributes'=>['placeholder'=>'Repeated password']])
->add('email', 'email', ['label'=>['value'=>'Email']])
    ->addElement(new \PHPForms\Elements\ParagraphElement(['content'=>'What is your name?']))
    ->add('text', 'name-question', ['label'=>['value'=>'Name'], 'id'=>'name-question'])
->addButton('Submit');
echo $register_form->asDivs('form-group');
$register_form->addData($_GET);


?>
</body>
</html>