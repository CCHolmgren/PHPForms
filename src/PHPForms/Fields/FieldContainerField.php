<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-31
 * Time: 10:18
 */

namespace PHPForms\Fields;


class FieldContainerField extends FormField implements \Iterator{
    use FieldContainer;
    protected $selfClosing = false;

    function rewind() {
        return reset($this->fields);
    }

    function current() {
        return current($this->fields);
    }

    function key() {
        return key($this->fields);
    }

    function next() {
        return next($this->fields);
    }

    function valid() {
        return key($this->fields) !== null;
    }
    protected function renderChildren(){
        $result = "";
        foreach($this as $field){
            $result .= $field->render();
        }
        return $result;
    }
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

        $result .= $this->renderChildren();

        $result .= "</{$this->tag}>";
        return  $result;
    }
} 