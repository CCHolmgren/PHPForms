<?php

namespace PHPForms\Elements;


class HTMLElement {
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
    protected $tag = 'div';
    /**
     * Whether this field should render or be skipped
     * @var bool
     */
    protected $shouldRender = true;
    /**
     * Whether this field is self closing (<input>) or not (<button></button>)
     * @var bool
     */
    protected $selfClosing = false;
    /**
     * Options, or attrbiutes of the field
     * Can be anything that you want. onclick, id, min, max, pattern or anything else
     * @var array
     */
    protected $options;
    protected $id = '';

    public function __construct(array $options = []) {
        $this->options = array_merge(['attributes' => [], 'classes' => [], 'content' => ''], $options);
    }
    /**
     * Renders this field, if it should be rendered
     * @return string
     */
    public function render() {
        if ($this->shouldRender) {
            $this->rendered = true;

            return $this->renderElement();
        }

        return "";
    }
    /**
     * Renders a field with all options and attributes given by this class
     * This is a generic renderField method
     * and it can be overloaded to provide more finegrained control over the field
     * @return string
     */
    protected function renderElement() {
        $result = "";
        $result .= $this->getOpeningTag();
        $result .= (!empty($this->options['content'])) ? $this->options['content'] : "";
        $result .= $this->getClosingTag();
        return $result;
    }
    protected function getOpeningTag() {
        $result = "";
        $result .= "<{$this->tag} ";
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

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }
} 