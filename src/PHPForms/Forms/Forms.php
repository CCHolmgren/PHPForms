<?php namespace PHPForms\Forms;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 09:33
 */
use PHPForms\Fields\FormField;
use PHPForms\Fields\ButtonField;
class Forms {
    protected $method = 'GET';
    protected $url;
    protected $fields = array();
    protected $fieldNames = array();
    protected $errors = array();
    protected $errorCount = 0;
    protected $formAttributes = array();

    public function __construct($method = "GET", $url = "", array $attributes = []) {
        $this->fields = array();
        $this->method = $method;
        $this->url = $url;
        $this->formAttributes = $attributes;
    }

    /**
     * Adds a FormField to this Form
     * @param FormField $field
     * @return Forms $this
     */
    public function addField(FormField $field) {
        var_dump($field);
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
     * @return Forms $this
     */
    //TODO: Make it use ButtonField better
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

    /**
     * Takes data, given field names, adds it to the field and validates it
     * Maybe it should be the other way around? (validate($data)?)
     * $data comes in the form [$fieldname => $valuetoaddtothatfield[, ...]]
     * TODO: Change the order, so that validate happens first
     * @param array $data Associative array with values to add to the given field with same name as the key in $data
     */
    public function addData($data){
        foreach($data as $key=>$value){
            $field = isset($this->fieldNames[$key]) ? $this->fieldNames[$key] : false;
            if ($field) {
                /** @var FormField $field */
                $field = $this->fieldNames[$key];
                $field->setValue($value);
                $field->validate();
            }
        }
    }
    public function getFormStart(){
        $result = '<form';
        if($this->method !== ""){
            $result .= " method='{$this->method}'";
        }
        if($this->url !== ""){
            $result .= " action='{$this->url}'";
        }
        if(isset($this->formAttributes)){
            foreach($this->formAttributes as $key=>$value){
                $result .= " $key='$value'";
            }
        }
        $result .= '>';
        return $result;
    }
    public function getFormEnd(){
        $result = "</form>";
        return $result;
    }
    /**
     * @param $formData
     * @return string
     */
    protected function formatForm($formData){
        $result = $this->getFormStart();
        $result .= $formData;
        $result .= $this->getFormEnd();
        return $result;
    }
    /**
     * Renders this form with all elements wrapped in a list, <ul><li></li></ul> structure
     * This is like Django's as_ul method for forms
     * @return string
     */
    public function asUnorderedList(){
        $result = '<ul>';
        foreach($this->fields as $field){
            $result .= "<li>";
            $result .= $field->render();
            $result .= "</li>";
        }
        $result .= '</ul>';
        return $this->formatForm($result);
    }

    /**
     * @return string
     */
    public function asTable() {
        $result = '<table>';
        foreach($this->fields as $field){
            $result .= "<tr>";
            $result .= "<td>" . $field->render() . "</td>";
            $result .= "</tr>";
        }
        $result .= '</table>';
        return $this->formatForm($result);
    }
    /**
     * Renders this field with all elements wrapped in paragraphs, <p>
     * This is like Django's as_p method for forms
     * @return string
     */
    public function asParagraph(){
        $result = '';
        /** @var FormField $field */
        foreach($this->fields as $field){
            $result .= "<p>";
            $result .= $field->render();
            $result .= "</p>";
        }
        return $this->formatForm($result);
    }
    /**
     * @return string
     */
    public function asDivs(){
        $result = '<div>';
        foreach($this->fields as $field){
            $result .= "<div>";
            $result .= $field->render();
            $result .= "</div>";
        }
        $result .= '</div>';
        return $this->formatForm($result);
    }
    public function getErrors(){
        foreach($this->fieldNames as $key=>$value){
            $errors = $value->getErrors();
            $this->errors[$key] = $errors;
        }
        return $this->errors;
    }
    public function isValid(){
        return count($this->errors, COUNT_RECURSIVE) - count($this->errors) == 0;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }
}