<?php namespace PHPForms\Fields;

use PHPForms\Validators\Validator;

class FormField {
    /**
     * @var array PHPForms\Validators\Validator
     */
    public $validators = array();
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
     * Options, or attrbiutes of the field
     * Can be anything that you want. onclick, id, min, max, pattern or anything else
     * @var array
     */
    protected $options;
    /**
     * Whether the field has been rendered yet
     * @var bool
     */
    protected $rendered = false;
    /**
     * Tag or element name, such as input, button, textarea, or anything else
     * Used in <$tag>[</$tag>]
     * @var string
     */
    protected $tag = 'input';
    /**
     * Whether this field should render or be skipped
     * @var bool
     */
    protected $shouldRender = true;
    /**
     * Whether this field is self closing (<input>) or not (<button></button>)
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

    public function __construct($name = '', $type = '', array $options = [], array $validators = []) {
        $this->name = $name;
        $this->type = $type;
        $this->options = array_merge(['value' => null, 'attributes' => [], 'classes' => []], $options);
        $this->value = $this->options['value'];
        $this->validators = $validators;
    }

    /**
     * Renders this field, if it should be rendered
     * @return string
     */
    public function render() {
        if ($this->shouldRender) {
            $this->rendered = true;

            return $this->renderField();
        }

        return "";
    }

    /**
     * Renders a field with all options and attributes given by this class
     * This is a generic renderField method
     * and it can be overloaded to provide more finegrained control over the field
     * @return string
     */
    protected function renderField($wrappedName = "") {
        $result = "";
        $result .= $this->getLabel();
        $result .= $this->getOpeningTag($wrappedName);
        if (!$this->selfClosing) {
            $result .= $this->value;
            $result .= $this->getClosingTag();
        }
        $result .= $this->getLabelStop();

        return $result;
    }

    protected function getLabel() {
        if (isset($this->options['label']['wrap']) && isset($this->options['label']['value'])) {
            return "<label>{$this->options['label']['value']}";

        } else if (isset($this->options['label']) && isset($this->options['label']['value'])) {
            return "<label for='{$this->options['label']['for']}'>{$this->options['label']['value']}</label>";
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
            $result .= "class='" . implode(" ", $this->options['classes']) . "'";
        }
        if (!empty($this->options['style'])) {
            $result .= " style='{$this->options['style']}'";
        }
        if (!empty($this->options['attributes'])) {
            foreach ($this->options['attributes'] as $key => $value) {
                $result .= " {$key}='{$value}' ";
            }
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
        if($this->name != ""){
            $this->setName($wrap . "[$this->name]");
        }
        return $this;
    }
}