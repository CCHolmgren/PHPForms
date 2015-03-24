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

    public function __construct($name, $type, array $options = []){
        $this->name = $name;
        $this->type = $type;
        $this->options = $options;
    }
    protected function renderField(){
        print_r($this->options);
        $result = "";
        $result .= "<{$this->tag} type='{$this->type}' name='{$this->name}'";
        if($this->name !== ""){
            $result .= "name = {$this->name}";
        }
        foreach($this->options as $key=>$value){
            $result .= "$key=$value ";
        }

        $result .= ">";
        return  $result;
    }
    public function render(){
        if($this->shouldRender){
            $this->rendered = true;
            return $this->renderField();
        }
    }
}