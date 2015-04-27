<?php
namespace PHPForms\Fields;

use PHPForms\Elements\HTMLElement;
use PHPForms\Forms;

trait FieldContainerTrait {
    protected $fields = array();
    protected $fieldNames = array();
    protected $errors = array();

    /**
     * Adds a FormField to this Form
     * @param FormField $field
     * @return $this
     */
    public function addField(FormField $field) {
        $name = $field->getName();
        if ($name == '' || !isset($this->fieldNames[$name])) {
            $this->fields[] = $field;
            if ($name != '') {
                $this->fieldNames[$name] = $field;
            }
        } else {
            trigger_error("You cannot add a field with name: {$name}, since there has already been one added.");
        }

        return $this;
    }
    public function addElement(HTMLElement $element){
        $this->fields[] = $element;
        return $this;
    }
    public function addNested(Forms\Forms $form, $name){
        $this->fields[] = $form;
        $this->fieldNames[$name] = $form;
        $form->setWrapped($name);
        return $this;
    }
    /**
     * Returns all fields that have been added
     * Includes non formfield elements as well
     * @return array
     */
    public function getFields() {
        return $this->fields;
    }
    public function getFieldNames(){
        return $this->fieldNames;
    }
    public function getValues(){
        $result = [];
        foreach($this->fields as $field){
            if($field instanceof FieldContainerInterface){
                foreach($field->getFieldNames() as $name=>$nested_field){
                    if(array_search($name, $result)){
                        $result[] = $field->getValue();
                    } else {
                        $result[$name] = $field->getValue();
                    }
                }
            } else if($field instanceof FormField){
                $name = $field->getName();
                if(array_search($name, $result)){
                    $result[] = $field->getValue();
                } else {
                    $result[$name] = $field->getValue();
                }
            }
        }
        return $result;
    }
    /**
     * Specialized method for adding a submit button to the form
     * Won't place it at the bottom
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function addButton($value, array $options = []) {
        $options = array_merge(['value' => $value], $options);
        $this->addField(new ButtonField('', 'submit', $options));

        return $this;
    }

    /**
     * Tries to create the field, and if it doesn't exist, create a generic FormField one
     * If the specialized class exists, it is assume to take the same arguments as FormField does
     * @param $field string Name of the class, and file, that should be created
     * @param $name string See $name on __construct on FormField
     * @param array $options See $options on __construct on FormField
     * @return $this
     */
    public function add($field, $name = '', array $options = []) {
        $options = array_merge([], $options);
        $new_field = 'PHPForms\\Fields\\' . $field . 'Field';
        if (class_exists($new_field)) {
            $this->addField(new $new_field($name, $field, $options));
        } else {
            $this->addField(new FormField($name, $field, $options));
        }

        return $this;
    }

    /**
     * Takes data, given field names, adds it to the field and validates it
     * Maybe it should be the other way around? (validate($data)?)
     * $data comes in the form [$fieldname => $valuetoaddtothatfield[, ...]]
     * TODO: Change the order, so that validate happens first
     * @param array $data Associative array with values to add to the given field with same name as the key in $data
     */
    public function addData($data) {
        foreach($this->fields as $field){
            if($field instanceof FieldContainerInterface){
                $field->addData($data);
            } else if ($field instanceof FormField && $field->getName() !== '') {
                $value = $data[$field->getName()];
                $field->setValue($value);
                $field->validate();
            }
        }
    }

    /**
     * This method will wrap all names of the fields with the $wrap value
     * As such, it is a dangerous method that will change all names that are available
     * @param $wrap
     * @return $this
     */
    public function setWrapped($wrap) {
        /** @var FormField $field */
        foreach ($this->fields as $field) {
            $field->setWrapped($wrap);
        }
        return $this;
    }

    public function getErrors() {
        /** @var FormField $field */
        foreach ($this->fieldNames as $name => $field) {
            $errors = $field->getFieldErrors();
            $this->errors[$name] = $errors;
        }

        return $this->errors;
    }

    public function isValid() {
        return count($this->errors, COUNT_RECURSIVE) - count($this->errors) == 0;
    }
}