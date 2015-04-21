<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-04-20
 * Time: 15:27
 */

namespace PHPForms\Fields;


class RepeatedPasswordField extends FieldContainerField {
    protected function restInitialize(){
        echo "restInitialize method called<br>";
        $this->add('password','password');
        var_dump($this->fieldNames);

        $this->add('password','password_confirmation');
        var_dump($this->fieldNames);
    }
    protected function renderElement($wrappedName = "", $showErrors = true) {
        $result = "";

        $result .= $this->renderChildren();

        return $result;
    }
    public function setType($type){

    }
} 