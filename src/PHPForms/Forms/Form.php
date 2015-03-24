<?php namespace PHPForms\Forms;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 09:33
 */
use PHPForms\Fields\FormField;
class Forms {
    private $fields = array();

    public function __construct() {
        $this->fields = array();
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
        $result = "<form>";
        foreach($this->fields as $field){
            $result .= "<p>";
            $result .= $field->render();
            $result .= "</p>";
        }
        $result .= "</form>";
        return $result;
    }
}