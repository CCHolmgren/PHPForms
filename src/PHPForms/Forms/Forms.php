<?php namespace PHPForms\Forms;

use PHPForms\Fields\FieldContainerInterface;
use PHPForms\Fields\FieldContainerTrait;
use PHPForms\Fields\FormField;

class Forms implements FieldContainerInterface{
    use FieldContainerTrait;
    protected $method = 'GET';
    protected $url;
    protected $errorCount = 0;
    protected $formAttributes = array();

    public function __construct($method = "GET", $url = "", array $attributes = []) {
        $this->method = $method;
        $this->url = $url;
        $this->formAttributes = $attributes;
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
        $result = '';
        foreach ($this->fields as $field) {
            if($field instanceof FieldContainerInterface){
                $result .= $field->render();
            } else {
                $result .= "<div";
                if ($divClass != '') {
                    $result .= " class='{$divClass}'";
                }
                $result .= '>';
                $result .= $field->render();
                $result .= '</div>';
            }
        }
        $result .= '';

        return $this->formatForm($result);
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
            $result .= '<div>';
            $result .= $field->render();
            $result .= '</div>';
        }
        return $result;
    }
}