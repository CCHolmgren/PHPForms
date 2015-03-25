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

    public function __construct(array $options = [], $text){
        $this->options = array_merge(['text' => ''], $options);
        $this->text = $text;
    }
}