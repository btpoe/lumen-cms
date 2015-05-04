<?php namespace App\Http\FieldTypes;

class Checkbox extends FieldType {

    protected function _config() {

        $output  = "";
        return $output;
    }

    protected function _render($field, array $options = []) {

        extract($this->fillOptions($field, $options));

        $output = '<div class="formplate">';

        $output .= "<span class=\"fp-checkbox\"><input id=\"$fieldId\" type=\"checkbox\" name=\"$field\" value=\"1\" /></span>";
        $output .= "<label for=\"$fieldId\">$labelText</label>";

        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

}