<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-30
 * Time: 11:16
 */

namespace PHPForms\Validators;


class RegexValidator implements  Validator {
    protected $regex;
    protected $message;
    protected $inverse_match;
    public function __construct($regex = "", $message = "", $inverse_match = false){
        $this->regex = $regex;
        $this->message = $message;
        $this->inverse_match = $inverse_match;
    }

    /**
     * Thank you django RegexValidator code for inverse match, simple but effective
     * @param $value
     * @return null|string'
     */
    public function validate($value){
        if(!$this->inverse_match == preg_match($this->regex, $value)){
            return null;
        } else {
            return $this->message;
        }
    }
} 