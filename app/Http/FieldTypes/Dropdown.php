<?php namespace App\Http\FieldTypes;

class Dropdown extends FieldType {

    public function __construct() {
        $this->Table = new Table();
    }

    protected function _config() {

        $output  = "";
        $output .= $this->Table->renderConfig('options', [
            'title' => 'Dropdown Options',
            'cols' => [
                [
                    'title' => 'Option Label',
                    'handle' => 'title',
                    'type' => 'single-line'
                ],[
                    'title' => 'Value',
                    'handle' => 'value',
                    'type' => 'single-line'
                ],[
                    'title' => 'Default',
                    'handle' => 'selected',
                    'type' => 'checkbox',
                    'width' => 50
                ]
            ]
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
        $output .= "<select id=\"$fieldId\" name=\"$field\">";

        foreach($options as $option) {
            extract($option, EXTR_PREFIX_ALL, 'opt');

            $output .= "<option value=\"$opt_value\" $opt_selected>$opt_title</option>";
        }

        $output .= '</select></div>';
        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

    protected function fillOptions($field, $params) {

        $parentOptions = parent::fillOptions($field, $params);
        $options = [];
        foreach($params['options'] as $key => $option) {
            if (!is_array($option)) {
                $option = [
                    'title' => $option,
                    'value' => $key
                ];
            }
            $option['selected'] = isset($params['selected']) && $params['selected'] == $option['value'] ? 'selected' : '';
            $options[] = $option;
        }
        return $parentOptions + compact('options');
    }

}