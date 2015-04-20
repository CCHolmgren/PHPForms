<?php namespace PHPForms\Fields;

use PHPForms\Elements\HTMLElement;
use PHPForms\Validators\Validator;

class FormField extends HTMLElement{
    /**
     * @var array PHPForms\Validators\Validator
     */
    public $validators = array();
    /**
     * Override the inherited $tag
     * @var string
     */
    protected $tag = 'input';
    /**
     * Name of the field
     * Used in <input name='$name'>
     * @var string
     */
    protected $name;
    /**
     * Type of the field, text, password, email or any other
     * Used in <input type='$type'>
     * @var string
     */
    protected $type;
    /**
     * Override the inherited $selfClosing
     * input is selfClosing, so it should be true here
     * @var bool
     */
    protected $selfClosing = true;
    /**
     * Text that will be the value, or string inside non selfclosing fields
     * Used in <input value='$text'> or <button>$text</button>
     * @var string
     */
    protected $value;
    protected $errors = array();
    protected $isValid = null;

    public function __construct($name = '', $type = '', array $options = []) {
        $this->name = $name;
        $this->setType($type);
        $this->options = array_merge(['value' => null, 'attributes' => [], 'classes' => [], 'validators' => [], 'id' => ''], $options);
        $this->value = $this->options['value'];
        $this->validators = $this->options['validators'];

        // Only try to set the id to the name, if there is an id or a name, otherwise it doesn't make much sense
        if(!empty($this->name) || !empty($this->options['id'])){
            $id = !empty($this->options['id']) ? $this->options['id']: $this->name;
            $this->setId($id);
        }
    }

    /**
     * Renders a field with all options and attributes given by this class
     * This is a generic renderField method
     * and it can be overloaded to provide more finegrained control over the field
     * @param string $wrappedName
     * @param bool $showErrors
     * @return string
     */
    protected function renderElement($wrappedName = "", $showErrors = true) {
        $result = "";
        $result .= $this->getLabel();
        $result .= $this->getOpeningTag($wrappedName);
        if (!$this->selfClosing) {
            $result .= $this->value;
            $result .= $this->getClosingTag();
        }
        $result .= $this->getLabelStop();
        if($showErrors){
            foreach($this->errors as $value){
                $result .= '<span>' . $value . '</span>';
            }
        }


        return $result;
    }

    protected function getLabel() {
        if (isset($this->options['label']['wrap']) && isset($this->options['label']['value'])) {
            return "<label>{$this->options['label']['value']}";
        } else if (isset($this->options['label']['value'])) {
            if(isset($this->options['label']['for'])){
                $for = $this->options['label']['for'];
            } else {
                $for = $this->getId();
            }
            return "<label for='{$for}'>{$this->options['label']['value']}</label>";
        } else {
            return "";
        }
    }

    protected function getOpeningTag($wrappedName = "") {
        $result = "";
        $result .= "<{$this->tag}";
        if (!empty($this->type)) {
            $result .= " type='{$this->type}'";
        }
        if (!empty($wrappedName) && !empty($this->name)) {
            $result .= " name='{$wrappedName}'";
        } else if (!empty($this->name)) {
            $result .= " name='{$this->name}'";
        }
        if($this->selfClosing){
            $result .= " value='{$this->value}'";
        }
        if (!empty($this->options['classes'])) {
            $result .= " class='" . implode(" ", $this->options['classes']) . "'";
        }
        if (!empty($this->options['style'])) {
            $result .= " style='{$this->options['style']}'";
        }
        if (!empty($this->options['attributes'])) {
            foreach ($this->options['attributes'] as $key => $value) {
                $result .= " {$key}='{$value}' ";
            }
        }
        $id = $this->getId();
        if(!empty($id)){
            $result .= " id='{$id}'";
        }
        $result .= ">";

        return $result;
    }

    protected function getClosingTag() {
        return "</{$this->tag}>";
    }

    protected function getLabelStop() {
        if (isset($this->options['label']['wrap'])) {
            return "</label>";
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @param string $text
     */
    public function setValue($text) {
        $this->value = $text;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     *
     */
    public function validate() {
        if (isset($this->validators)) {
            foreach ($this->validators as $validator) {
                if ($validator instanceof Validator) {
                    $result = $validator->validate($this->value);
                } else {
                    $result = $validator($this->value);
                }
                if ($result !== null) {
                    $this->errors[] = $result;
                }
            }
            if(count($this->errors)){
                $this->isValid = true;
            } else {
                $this->isValid = false;
            }
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setWrapped($wrap) {
        if(!empty($this->name)){
            $this->setName($wrap . "[$this->name]");
        }
        return $this;
    }
    public function toString(){
        return $this->renderElement("", false);
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }
}