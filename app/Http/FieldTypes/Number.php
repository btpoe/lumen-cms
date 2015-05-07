<?php namespace App\Http\FieldTypes;

class Number extends FieldType {

    protected function _config() {

        $output  = '';
        $output .= $this->render('min', [
            'title' => 'Min Length'
        ]);
        $output .= $this->render('max', [
            'title' => 'Max Length'
        ]);
        $output .= $this->render('decimal', [
            'title' => 'Decimal Points'
        ]);
        return $output;
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate">';

        $output .= "<label for=\"$fieldId\">$title</label>";
        if ($instructions) {
            $output .= "<p><small>$instructions</small></p>";
        }
        $output .= "<input type=\"number\" id=\"$fieldId\" name=\"$field\" $min $max $decimal $value />";

        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

    protected function fillOptions($field, $params) {

        $parentOptions = parent::fillOptions($field, $params);
        $min = isset($params['min']) ? "min=\"{$params['min']}\"" : '';
        $max = isset($params['max']) ? "max=\"{$params['max']}\"" : '';
        $decimal = isset($params['decimal']) ? "data-decimal=\"{$params['decimal']}\"" : '';
        $value = isset($params['value']) ? "value=\"{$params['value']}\"" : '';
        return $parentOptions + compact('min', 'max', 'decimal', 'value');
    }

}