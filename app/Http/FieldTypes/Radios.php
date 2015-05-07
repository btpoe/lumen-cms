<?php namespace App\Http\FieldTypes;

class Radios extends FieldType {

    public function __construct() {
        $this->Table = new Table();
    }

    protected function _config() {

        $output  = "";
        $output .= $this->Table->renderConfig('options', [
            'title' => 'Radio Options',
            'add_row' => 'Add an option',
            'cols' => [
                [
                    'heading' => 'Title',
                    'handle' => 'title',
                    'type' => 'single-line'
                ],[
                    'heading' => 'Value',
                    'handle' => 'value',
                    'type' => 'single-line'
                ]
            ]
        ]);
        return $output;
    }

    protected function _render($field, array $params = []) {

        extract($this->fillOptions($field, $params));

        $output = '<div class="formplate">';

        foreach($options as $key => $option) {

            extract($option, EXTR_PREFIX_ALL, 'opt');

            $output .= "<span class=\"fp-radio $opt_checked\"><input id=\"$fieldId$key\" type=\"radio\" name=\"$field\" value=\"$opt_value\" $opt_checked /></span>";
            $output .= "<label for=\"$fieldId$key\">$opt_title</label>";
        }

        $output .= '</div>';

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
            $option['checked'] = isset($params['selected']) && $params['selected'] === $option['value'] ? 'checked' : '';
            $options[] = $option;
        }
        return $parentOptions + compact('options');
    }

}