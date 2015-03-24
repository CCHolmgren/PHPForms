<?php namespace PHPForms\Forms;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-23
 * Time: 14:11
 */
use PHPForms\Fields\FormField;

class FormBuilder {
    private $form;

    public function __construct() {
        $this->form = new Forms();
    }

    public function addField(FormField $field) {
        $this->form->addField($field);

        return $this;
    }
    public function addButton($value, $options = []){
        $this->form->addButton($value, $options);
        return $this;
    }

    /**
     * @return Forms
     */
    public function form() {
        return $this->form;
    }
}