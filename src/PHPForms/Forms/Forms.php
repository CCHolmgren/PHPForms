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

    public function __construct($method = "", $url = "") {
        $this->fields = array();
        $this->method = $method;
        $this->url = $url;
    }

    /**
     * Adds a FormField to this Form
     * @param FormField $field
     * @return Forms $this
     */
    public function addField(FormField $field) {
        if(!isset($this->fieldNames[$field->getName()])){
            $this->fields[] = $field;
            $this->fieldNames[$field->getName()] = $field;
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
    public function addButton($value, $options = []){
        $options = array_merge(['value' => $value], $options);
        $this->fields[] = new ButtonField('', 'submit', $options);

        return $this;
    }
    public function addData($data){
        foreach($data as $key=>$value){
            if (isset($this->fieldNames[$key])) {
                var_dump($this->fieldNames[$key]);
                $this->fieldNames[$key]->setValue($value);
                $this->fieldNames[$key]->validate();
            }
        }
    }
    /**
     * Renders this field with all elements wrapped in paragraphs, <p>
     * This is like Django's to_p method for forms
     * @return string
     */
    public function asParagraph(){
        $result = '<form';
        if($this->method !== ""){
            $result .= " method='{$this->method}'";
        }
        if($this->url !== ""){
            $result .= " action='{$this->url}''";
        }
        $result .= '>';
        foreach($this->fields as $field){
            $result .= "<p>";
            $result .= $field->render();
            $result .= "</p>";
        }
        $result .= "</form>";
        return $result;
    }

    /**
     * @param $formData
     * @return string
     */
    protected function formatForm($formData){
        $result = '<form';
        if($this->method !== ""){
            $result .= " method='{$this->method}'";
        }
        if($this->url !== ""){
            $result .= " action='{$this->url}'";
        }
        $result .= '>';
        $result .= $formData;
        $result .= "</form>";
        return $result;
    }
    /**
     * Renders this form with all elements wrapped in a list, <ul><li></li></ul> structure
     * This is like Django's to_ul method for forms
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
            $this->errors[$key] = $value->getErrors();
        }
        return $this->errors;
    }
}