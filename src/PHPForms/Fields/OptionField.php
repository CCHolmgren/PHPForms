<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-31
 * Time: 10:32
 */

namespace PHPForms\Fields;


class OptionField extends FormField{
    protected $tag = 'option';
    protected $selfClosing = false;

    protected function renderField(){
        $result = "";
        $result .= "<{$this->tag}";
        $result .= " value='{$this->value}'>";
        $result .= $this->options['text'];
        $result .= "</{$this->tag}>";
        return $result;
    }
} 