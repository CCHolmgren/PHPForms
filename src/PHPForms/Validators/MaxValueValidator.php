<?php namespace PHPForms\Validators;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-26
 * Time: 15:40
 */
class MaxValueValidator implements Validator{
    protected $maxValue;
    protected $message;
    public function __construct($maxValue,$message){
        $this->maxValue = $maxValue;
        $this->message = $message;
    }
    public function validate($value){
        if($value > $this->maxValue){
            return $this->message;
        } else {
            return null;
        }
    }
}