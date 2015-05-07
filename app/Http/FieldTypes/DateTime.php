<?php namespace App\Http\FieldTypes;

class DateTime extends FieldType {

    public function __construct() {
        $this->Radios = new Radios();
        $this->Dropdown = new Dropdown();
    }

    protected function _config() {

        $output  = "";
        $output .= $this->Radios->renderConfig('show', [
            'options' => [
                'date' => 'Show date',
                'time' => 'Show time',
                'datetime' => 'Show date and time'
            ],
            'selected' => 'date'
        ]);
        $output .= $this->Dropdown->renderConfig('increment', [
            'options' => [
                5 => '5',
                15 => '15',
                30 => '30'
            ]
        ]);
        return $output;
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate">';

        $output .= "<label for=\"$fieldId\">$title</label>";
        if (!empty($instructions)) {
            $output .= "<p><small>$instructions</small></p>";
        }
        $output .= "<input id=\"$fieldId\" type=\"text\" name=\"$field\" $value />";

        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

    protected function fillOptions($field, $params) {

        $parentOptions = parent::fillOptions($field, $params);
        $value = isset($params['value']) ? "value=\"{$params['value']}\"" : null;
        return $parentOptions + compact('value');
    }

}