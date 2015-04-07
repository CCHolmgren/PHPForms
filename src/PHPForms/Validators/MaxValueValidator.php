<?php namespace PHPForms\Validators;
class MaxValueValidator implements Validator {
    protected $maxValue;
    protected $message;

    public function __construct($maxValue, $message) {
        $this->maxValue = $maxValue;
        $this->message = $message;
    }

    public function validate($value) {
        if ($value > $this->maxValue) {
            return $this->message;
        } else {
            return null;
        }
    }
}