<?php namespace App\CMS\FieldTypes;

class PlainText extends FieldType {

    public function __construct()
    {
        $this->Number = new Number();
        $this->Checkboxes = new Checkboxes();
    }

    protected function _config()
    {
        $output  = '';
        $output .= $this->render('placeholder', [
            'title' => 'Placeholder Text',
            'instructions' => 'The text that will be shown if the field doesn\'t have a value.',
            'max_length' => 255
        ]);
        $output .= $this->Number->render('max_length', [
            'min' => 0, 'max' => 255
        ]);
        $output .= $this->Checkboxes->render('allow_break', [
            'options' => [
                '1' => 'Allow Line Breaks'
            ]
        ]);
        return $output;
    }

    protected function _process(array $settings = [])
    {
        return $settings;
    }

    protected function fillOptions($field, $params)
    {
        $placeholder = isset($params['placeholder']) ? "placeholder=\"{$params['placeholder']}\"" : '';
        $maxlength = isset($params['max_length']) ? "maxlength=\"{$params['max_length']}\"" : '';
        return parent::fillOptions($field, $params) + compact('placeholder', 'maxlength');
    }

}