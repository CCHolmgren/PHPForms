<?php namespace PHPForms\Forms;

use PHPForms\Fields\FormField;

class FormBuilder {
    public $form;

    public function __construct($method = 'GET', $url = '', array $attributes = []) {
        $this->form = new Forms($method, $url, $attributes);
    }

    public function add($field, $name, $type, $options = [], $validators = []) {
        $this->form->add($field, $name, $type, $options, $validators);

        return $this;
    }

    public function addField(FormField $field) {
        $this->form->addField($field);

        return $this;
    }

    public function addButton($value, $options = []) {
        $this->form->addButton($value, $options);

        return $this;
    }

    public function validate() {
    }

    public function addData($data) {
        $this->form->addData($data);
    }
}