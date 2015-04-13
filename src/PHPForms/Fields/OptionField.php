<?php

namespace PHPForms\Fields;


class OptionField extends FormField {
    protected $tag = 'option';
    protected $selfClosing = false;

    protected function renderField($wrappedName = "", $showErrors = false) {
        $result = "";
        $result .= "<{$this->tag} value='{$this->value}'>";
        $result .= $this->options['text'];
        $result .= "</{$this->tag}>";

        return $result;
    }
} 