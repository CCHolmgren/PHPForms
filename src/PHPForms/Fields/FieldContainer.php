<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-30
 * Time: 13:47
 */
namespace PHPForms\Fields;
trait FieldContainer{
    protected $fields = array();
    protected $fieldNames = array();

    /**
     * Adds a FormField to this Form
     * @param FormField $field
     * @return $this
     */
    public function addField(FormField $field) {
        if($field->getName() == '' || !isset($this->fieldNames[$field->getName()])){
            $this->fields[] = $field;
            if($field->getName() != ''){
                $this->fieldNames[$field->getName()] = $field;
            }
        } else {
            trigger_error("You cannot add a field with name: {$field->getName()}, since there has already been one added.");
        }
        return $this;
    }

    /**
     * Returns all fields that are added
     * @return array
     */
    public function getFields() {
        return $this->fields;
    }
    /**
     * Specialized method for adding a submit button to the form
     * Won't place it at the bottom
     * @param string $value
     * @param array $options
     * @return $this
     */
    public function addButton($value, array $options = []){
        $options = array_merge(['value' => $value], $options);
        $this->fields[] = new ButtonField('', 'submit', $options);

        return $this;
    }

    /**
     * Tries to create the field, and if it doesn't exist, create a generic FormField one
     * If the specialized class exists, it is assume to take the same arguments as FormField does
     * @param $field string Name of the class, and file, that should be created
     * @param $name string See $name on __construct on FormField
     * @param $type string See $type on __construct on FormField
     * @param array $options See $options on __construct on FormField
     * @param array $validators See $validators on __construct on FormField
     */
    public function add($field, $name, $type, $options = [], $validators = []){
        $options = array_merge([], $options);
        $field = 'PHPForms\\Fields\\' . $field . 'Field';
        if(class_exists($field)){
            echo "Class existed";
            $this->fields[] = new $field($name, $type, $options, $validators);
        } else {
            echo "Class did not exist";
            $this->fields[] = new FormField($name, $type, $options, $validators);
        }
    }
}