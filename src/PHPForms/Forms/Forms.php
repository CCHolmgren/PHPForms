<?php namespace PHPForms\Forms;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 09:33
 */
use PHPForms\Fields\FormField;
class Forms {
    protected $method = 'GET';
    protected $url;
    protected $fields = array();
    protected $errors = array();

    public function __construct($method = "", $url = "") {
        $this->fields = array();
        $this->method = $method;
        $this->url = $url;
    }

    public function addField(FormField $field) {
        $this->fields[] = $field;

        return $this;
    }
    public function getFields() {
        return $this->fields;
    }
    public function addButton($name, $options = []){
        $options = array_merge(['value' => $name], $options);
        $this->fields[] = new FormField('', 'submit', $options);

        return $this;
    }
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
}