<?php

namespace PHPForms\Fields;


class FieldContainerField extends FormField implements \Iterator {
    use FieldContainer;
    /**
     * By definition a Field that contains other fields, such as the select field
     * Must be non-selfclosing
     * @var bool
     */
    protected $selfClosing = false;

    function rewind() {
        return reset($this->fields);
    }

    function current() {
        return current($this->fields);
    }

    /* Iterator */

    function key() {
        return key($this->fields);
    }

    function next() {
        return next($this->fields);
    }

    function valid() {
        return key($this->fields) !== null;
    }

    protected function renderElement($wrappedName = "", $showErrors = true) {
        $result = "";
        $result .= $this->getOpeningTag($wrappedName);

        $result .= $this->renderChildren();

        $result .= $this->getClosingTag();

        return $result;
    }

    protected function renderChildren() {
        $result = "";
        foreach ($this as $field) {
            $result .= $field->render();
        }

        return $result;
    }
    /* Iterator */
} 