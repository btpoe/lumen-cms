<?php namespace App\Http\FieldTypes;

class Color extends FieldType {

    protected function _config() {

        return 'No config settings.';
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate">';

        $output .= "<label for=\"$fieldId\">$title</label>";
        if ($instructions) {
            $output .= "<p><small>$instructions</small></p>";
        }
        $output .= "<input type=\"color\" id=\"$fieldId\" name=\"$field\" $value />";


        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

}