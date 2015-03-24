<?php namespace PHPForms\Fields;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-24
 * Time: 16:27
 */
class PasswordField extends FormField {
    protected $type = 'password';
    public function __construct($name, array $options = []){
        $this->name = $name;
        $this->options = $options;
    }
}