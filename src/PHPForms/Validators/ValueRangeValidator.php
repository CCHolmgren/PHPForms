<?php

namespace PHPForms\Validators;


class ValueRangeValidator implements Validator {
    protected $minValue;
    protected $maxValue;
    protected $message;

    public function __construct($minValue, $maxValue, $message) {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->message = $message;
    }

    public function validate($value) {
        if ($this->minValue > $value || $value > $this->maxValue) {
            return $this->message;
        } else {
            return null;
        }
    }
} 