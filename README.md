# PHPForms
Form Builder for PHP 5.4+


A simple validator that implements the Validator interface.
```php
/*
 * A simple class-based validator that implements the Validator interface
 * This class does not do anything difficult, so we could just use a function based validator here
 */
class ValidatorYes implements Validator{
    public function validate($value){
        echo "Validate called with some odd value:  $value";
        return "This is not right!";
    }
}
```
This could also be done just by doing:
```php
function ValidatorYes($value){
    echo "Validate called with some odd value:  $value";
    return "This is not right!";
}
```

Doing it like Laravel Form Builder does it, but without the helper:
```php
/*
 * Inheriting from Forms allows you to use it as LFB does
 */
class PostForm extends Forms {
    public function buildForm()
    {
        $this
            ->add('text', 'name', 'text', ['classes'=>['form-control']])
            ->add('textarea','lyrics', 'text')
            ->add('checkbox', 'publish', 'checkbox')
            ->add('button', '', 'submit',['value'=>'Submit']);
        return $this;
    }
}
$x = new PostForm();
echo $x->buildForm()->asDivs('form-group'); // This wraps the inputs in divs with the class form-group on them
```

A large example displaying many of the different ways to do stuff, validators, addField, add, addButton methods, fieldsets and so on.
```php
$formbuilder = new FormBuilder();

$fieldset = new \PHPForms\Fields\FieldsetField();
$fieldset->addField(new ButtonField('', 'button', ['value'=>'Empty click']));
$fieldset->addField(new LegendField('', '', ['value'=>'Testing, testing']));

$select = new \PHPForms\Fields\SelectField();
$select->addField(new \PHPForms\Fields\OptionField('','',['value'=>'1','text'=>'My text']));
$select->addField(new \PHPForms\Fields\OptionField('','',['value'=>'2', 'text'=>'Some other text']));

// The fields are instantiated with the values $name, $type, $options
// Text that should appear under value, is placed under $options['value'] and so on
// Attributes are placed under $options['attributes'] and css - classes $options['classes']

$formbuilder->addField(
        new FormField('test', 'number', ['value'=>"Test"], [new \PHPForms\Validators\ValueRangeValidator(1, 3, "Value must be between 1 and 3")/*, new \PHPForms\Validators\MinValueValidator(8, "Value must be at least 8.")*/, new \PHPForms\Validators\MaxValueValidator(5, "Value must be at most 5."), new \PHPForms\Validators\RegexValidator('/3/', "Must not be 3", true),
        new \PHPForms\Validators\RegexValidator('/2/', "Must be 2", false), function($value){
                return "No can do!";
            }])) // A lot of validators. Displaying Classbased validation and also method validation. This of course works if you pass a string to a method as well
    ->addButton('Submit', ['onclick' => 'alert("test")', 'style'=>'border:10px solid black;']) // A button added by the helper addButton, this will always create a submit button. Displaying setting onclick of the button, and also style
    ->addField(new ButtonField('', 'button', ['value'=>'Empty click','label'=>['wrap'=>true, 'value'=>'This is my label']])) // Button that is wrapped by a label with the text 'This is my label'
    ->addField(new ButtonButtonField('', '',['value'=>'Hello there']))
    ->addField(new PasswordField('password'))
    ->addField(new ButtonField('', 'submit', ['value'=>'Another one']))
    ->add('Button', '', '') // Generic add method. This tries to create a field with the class ButtonField
    ->add('Password', '','') // Generic add method. This tries to create a field with the class PasswordField, name = '', and type = '' since it doesn't care about type
    ->addField(new TextareaField('test-name', '', ['value'=>'Hello the textarea'])) // Textarea with name test-name, and the type doesn't matter. The text that will be in the textarea is given by 'value'=>'Hello the textarea'
    ->addField(new FormField('someothername', 'text')) // FormField is a generic field, so the element will be a <input name='someothername' type='text'> in this case
    ->addField($select) // Adding already created elements
    ->addField($fieldset); // Adding a fieldset, that is already created

echo $formbuilder->form->asParagraph();
```

You can output the same form as many times as you want. You can also change the method and then output it again, without any problem.
```php
echo $formbuilder->form->asDivs();

echo $formbuilder->form->asParagraph();

echo $formbuilder->form->asUnorderedList();

$formbuilder->form->setMethod('POST');
echo $formbuilder->form->asTable();
```

Adding data to the form is as easy as just calling addData with either $_POST or $_GET. You can of course do it any way, addData just expects an associative array.
```php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $formbuilder->addData($_POST);
} else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formbuilder->addData($_GET);
}
```