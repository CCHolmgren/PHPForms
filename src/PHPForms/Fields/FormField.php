<?php namespace PHPForms\Fields;
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2015-03-23
 * Time: 14:33
 */
use PHPForms\Validators\Validator;
class FormField {
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
     * Whether this field is selfclosing (<input>) or not (<button></button>)
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

    /**
     * @var array PHPForms\Validators\Validator
     */
    public $validators = array();
    public function __construct($name = '', $type = '', array $options = [], array $validators = []){
        $this->name = $name;
        $this->type = $type;
        $this->options = array_merge(['value' => null, 'attributes' => [], 'classes' => []], $options);
        $this->value = $this->options['value'];
        $this->validators = $validators;
    }

    /**
     * Renders a field with all options and attributes given by this class
     * This is a generic renderField method
     * and it can be overloaded to provide more finegrained control over the field
     * @return string
     */
    protected function renderField(){
        $result = "";
        $result .= "<{$this->tag}";
        if($this->type !== ""){
            $result .= " type='{$this->type}'";
        }
        if($this->name !== ""){
            $result .= " name='{$this->name}'";
        }
        if(!empty($this->options['attributes'])){
            foreach($this->options['attributes'] as $key=>$value){
                $result .= " $key='$value' ";
            }
        }
        $result .= " value='{$this->value}'";
        if(!empty($this->options['classes'])){
            $result .= " class='";
            foreach($this->options['classes'] as $value){
                $result .= $value;
            }
            $result .= "'";
        }
        if(isset($this->options['style'])){
            $result .= " style='{$this->options['style']}'";
        }
        $result .= ">";
        if(!$this->selfClosing){
            $result .= $this->value;
            $result .= "</{$this->tag}>";
        }
        return  $result;
    }

    /**
     * Renders this field, if it should be rendered
     * @return string
     */
    public function render(){
        if($this->shouldRender){
            $this->rendered = true;
            return $this->renderField();
        }
        return "";
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
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
    public function validate(){
        if(isset($this->validators)){
            /** @var $validator */
            foreach($this->validators as $validator){
                if($validator instanceof Validator){
                    $result = $validator->validate($this->value);
                } else {
                    $result = $validator($this->value);
                }
                if($result !== null){
                    $this->errors[] = $result;
                }
            }
        }
    }
}