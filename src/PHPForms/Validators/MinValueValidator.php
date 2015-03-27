<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-26
 * Time: 16:24
 */

namespace PHPForms\Validators;


class MinValueValidator implements Validator {
    protected $minValue;
    protected $message;
    public function __construct($minValue, $message){
        $this->minValue = $minValue;
        $this->message = $message;
    }
    public function validate($value){
        if($value < $this->minValue){
            return $this->message;
        } else {
            return null;
        }
    }
} 