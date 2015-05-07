<?php namespace App\Http\FieldTypes;

class Color extends FieldType {

    protected function _config() {

        return 'No config settings.';
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate"></div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

}