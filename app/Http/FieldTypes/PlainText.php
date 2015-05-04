<?php namespace App\Http\FieldTypes;

class PlainText extends FieldType {

    public function __construct() {
        $this->PlainText = $this;
        $this->Checkboxes = new Checkboxes();
    }

    protected function _config() {

        $output  = '';
        $output .= $this->renderConfig('placeholder', ['label' => 'Placeholder Text', 'instructions' => 'The text that will be shown if the field doesn\'t have a value.']);
        $output .= $this->renderConfig('max_length', ['instructions' => 'The text that will be shown if the field doesn\'t have a value.']);
        $output .= $this->Checkboxes->renderConfig('allow_break', ['label' => 'Allow Line Breaks']);
        return $output;
    }

    protected function _render($field, array $options = []) {

        extract($this->fillOptions($field, $options));

        $output = '<div class="formplate">';

        $output .= "<label for=\"$fieldId\">$labelText</label>";
        if (!empty($instructions)) {
            $output .= "<p><small>$instructions</small></p>";
        }
        $output .= "<input id=\"$fieldId\" type=\"text\" name=\"$field\" />";

        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

}