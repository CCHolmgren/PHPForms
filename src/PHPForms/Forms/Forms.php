<?php namespace PHPForms\Forms;

use PHPForms\Fields\FieldContainer;
use PHPForms\Fields\FormField;

class Forms {
    use FieldContainer;
    protected $method = 'GET';
    protected $url;
    protected $errors = array();
    protected $errorCount = 0;
    protected $formAttributes = array();

    public function __construct($method = "GET", $url = "", array $attributes = []) {
        $this->method = $method;
        $this->url = $url;
        $this->formAttributes = $attributes;
    }

    /**
     * Takes data, given field names, adds it to the field and validates it
     * Maybe it should be the other way around? (validate($data)?)
     * $data comes in the form [$fieldname => $valuetoaddtothatfield[, ...]]
     * TODO: Change the order, so that validate happens first
     * @param array $data Associative array with values to add to the given field with same name as the key in $data
     */
    public function addData($data) {
        foreach ($data as $key => $value) {
            $field = isset($this->fieldNames[$key]) ? $this->fieldNames[$key] : false;
            if ($field) {
                /** @var FormField $field */
                $field = $this->fieldNames[$key];
                $field->setValue($value);
                $field->validate();
            }
        }
    }

    /**
     * Renders this form with all elements wrapped in a list, <ul><li></li></ul> structure
     * This is like Django's as_ul method for forms
     * @return string
     */
    public function asUnorderedList() {
        $result = '<ul>';
        foreach ($this->fields as $field) {
            $result .= "<li>";
            $result .= $field->render();
            $result .= "</li>";
        }
        $result .= '</ul>';

        return $this->formatForm($result);
    }

    /**
     * @param $formData
     * @return string
     */
    protected function formatForm($formData) {
        $result = $this->getFormStart();
        $result .= $formData;
        $result .= $this->getFormEnd();

        return $result;
    }

    public function getFormStart() {
        $result = '<form';
        if ($this->method !== "") {
            $result .= " method='{$this->method}'";
        }
        if ($this->url !== "") {
            $result .= " action='{$this->url}'";
        }
        if (isset($this->formAttributes)) {
            foreach ($this->formAttributes as $key => $value) {
                $result .= " $key='$value'";
            }
        }
        $result .= '>';

        return $result;
    }

    public function getFormEnd() {
        $result = "</form>";

        return $result;
    }

    /**
     * @return string
     */
    public function asTable() {
        $result = '<table>';
        foreach ($this->fields as $field) {
            $result .= "<tr>";
            $result .= "<td>" . $field->render() . "</td>";
            $result .= "</tr>";
        }
        $result .= '</table>';

        return $this->formatForm($result);
    }

    /**
     * Renders this field with all elements wrapped in paragraphs, <p>
     * This is like Django's as_p method for forms
     * @return string
     */
    public function asParagraph() {
        $result = '';
        /** @var FormField $field */
        foreach ($this->fields as $field) {
            $result .= "<p>";
            $result .= $field->render();
            $result .= "</p>";
        }

        return $this->formatForm($result);
    }

    /**
     * @return string
     */
    public function asDivs($divClass = "") {
        $result = '<div>';
        foreach ($this->fields as $field) {
            $result .= "<div";
            if ($divClass != '') {
                $result .= " class='{$divClass}'";
            }
            $result .= '>';
            $result .= $field->render();
            $result .= '</div>';
        }
        $result .= '</div>';

        return $this->formatForm($result);
    }

    /**
     * This method will wrap all names of the fields with the $wrap value
     * As such, it is a dangerous method that will change all names that are available
     * @param $wrap
     * @return $this
     */
    public function setWrapped($wrap) {
        /** @var FormField $field */
        foreach ($this->fields as $field) {
            $field->setWrapped($wrap);
        }
        return $this;
    }

    public function getErrors() {
        foreach ($this->fieldNames as $key => $value) {
            $errors = $value->getErrors();
            $this->errors[$key] = $errors;
        }

        return $this->errors;
    }

    public function isValid() {
        return count($this->errors, COUNT_RECURSIVE) - count($this->errors) == 0;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }
    public function render(){
        $result = '';
        foreach ($this->fields as $field) {
            $result .= $field->render();
        }
        return $result;
    }
}