<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-26
 * Time: 16:31
 */

namespace PHPForms\Validators;


class ValueRangeValidator implements Validator {
    protected $minValue;
    protected $maxValue;
    protected $message;
    public function __construct($minValue, $maxValue, $message){
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->message = $message;
    }
    public function validate($value){
        if($this->minValue > $value || $value > $this->maxValue){
            return $this->message;
        } else {
            return null;
        }
    }
} 