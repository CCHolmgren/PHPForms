<?php namespace PHPForms\Fields;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 16:12
 */
class ButtonButtonField extends FormField {
    protected $type = 'button';
    protected $selfClosing = false;
    protected $tag = 'button';

    public function __construct(array $options = []){
        $this->options = array_merge(['text' => ''],$options);
    }
    protected function renderField(){
        print_r($this->options);
        $result = "";
        $result .= "<{$this->tag} ";
        foreach($this->options as $key=>$value){
            if($key !== 'text'){
                $result .= "{$key}={$value} ";
            }
        }
        $result .= ">";
        if(!$this->selfClosing){
            $result .= $this->options['text'];
            $result .= "</{$this->tag}>";
        }
        return  $result;
    }
}