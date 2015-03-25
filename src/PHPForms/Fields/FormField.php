<?php namespace PHPForms\Fields;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-23
 * Time: 14:33
 */
class FormField {
    protected $name;

    protected $type;

    protected $options;

    protected $rendered = false;

    protected $tag = 'input';

    protected $shouldRender = true;

    protected $selfClosing = true;

    protected $text;

    public function __construct($name = "", $type = 'input', array $options = [], $text = ""){
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
        $this->text = $text;
    }
    protected function renderField(){
        print_r($this->options);
        $result = "";
        $result .= "<{$this->tag}";
        if($this->type !== ""){
            $result .= " type='{$this->type}'";
        }
        if($this->name !== ""){
            $result .= " name='{$this->name}'";
        }
        foreach($this->options as $key=>$value){
            $result .= " $key=$value ";
        }

        $result .= ">";
        if(!$this->selfClosing){
            $result .= $this->text;
            $result .= "</{$this->tag}>";
        }
        return  $result;
    }
    public function render(){
        if($this->shouldRender){
            $this->rendered = true;
            return $this->renderField();
        }
    }
}