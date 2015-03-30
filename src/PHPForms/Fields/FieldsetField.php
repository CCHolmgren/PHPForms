<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-30
 * Time: 13:46
 */

namespace PHPForms\Fields;


class FieldsetField extends FormField {
    protected $tag = "fieldset";
    protected $selfClosing = false;

    use FieldContainer;
    protected function renderField(){
        $result = "";
        $result .= "<{$this->tag}";
        if($this->type !== ""){
            $result .= " type='{$this->type}'";
        }
        if($this->name !== ""){
            $result .= " name='{$this->name}'";
        }
        if(!empty($this->options['attributes'])){
            foreach($this->options['attributes'] as $key=>$value){
                $result .= " $key='$value' ";
            }
        }
        $result .= " value='{$this->value}'";
        if(!empty($this->options['classes'])){
            $result .= " class='";
            foreach($this->options['classes'] as $value){
                $result .= $value;
            }
            $result .= "'";
        }
        if(isset($this->options['style'])){
            $result .= " style='{$this->options['style']}'";
        }
        $result .= ">";
        foreach($this->fields as $field){
            $result .= $field->render();
        }
        $result .= "</{$this->tag}>";
        return  $result;
    }
} 