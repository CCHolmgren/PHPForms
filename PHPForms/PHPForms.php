<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-23
 * Time: 14:11
 */
class PHPForms {
    private $fields;
    public function __construct(){
        $this->fields = new FieldsContainer();
    }
    public function add_field(Field $field){
        $this->fields->add_field($field);
    }
    public function begin_row(){

    }
    public function end_row(){

    }
    public function to_p(){
        $result = "";
        /** @var Field $field */
        foreach($this->fields as $field){
            $result .= '<p>';
            $result .= $field->to_s();
            $result .= '</p>';
        }
        return $result;
    }
}