<?php namespace App\Http\FieldTypes;

class RichText extends FieldType {

    public function __construct() {
        $this->Number = new Number();
        $this->Checkboxes = new Checkboxes();
    }

    protected function _config() {

        $output  = '';
        $output .= $this->Checkboxes->render('clean', [
            'options' => [
                '1' => 'Clean HTML?'
            ]
        ]);
        $output .= $this->Checkboxes->render('purify', [
            'options' => [
                '1' => 'Purify HTML?'
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
        $output .= "<input type=\"text\" id=\"$fieldId\" name=\"$field\" $value $placeholder $maxlength />";

        $output .= '</div>';

        return $output;
    }

    protected function _process(array $settings = []) {
        return $settings;
    }

}