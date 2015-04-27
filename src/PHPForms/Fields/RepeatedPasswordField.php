<?php

namespace PHPForms\Fields;

class RepeatedPasswordField extends FieldContainerField {
    protected function restInitialize(){
        $this->add('password','password');
        $this->add('password','password_confirmation');
    }
    protected function renderElement($wrappedName = "", $showErrors = true) {
        $result = "";

        $result .= $this->renderChildren();

        return $result;
    }
    public function setType($type){
    }
} 