<?php namespace PHPForms\Fields;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-25
 * Time: 09:14
 */

class TextareaField extends FormField{
    protected $tag = 'textarea';

    protected $selfClosing = false;

    public function __construct($name = "", array $options = [], $text = ""){
        $this->name = $name;
        $this->options = array_merge([], $options);
        $this->text = $text;
    }
}