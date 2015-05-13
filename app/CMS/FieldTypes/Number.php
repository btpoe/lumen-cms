<?php namespace App\CMS\FieldTypes;

class Number extends FieldType {

    protected function _config()
    {
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

    protected function _process(array $settings = [])
    {
        return $settings;
    }

    protected function fillOptions($field, $params)
    {
        $min = isset($params['min']) ? "min=\"{$params['min']}\"" : '';
        $max = isset($params['max']) ? "max=\"{$params['max']}\"" : '';
        $decimal = isset($params['decimal']) ? "data-decimal=\"{$params['decimal']}\"" : '';
        return parent::fillOptions($field, $params) + compact('min', 'max', 'decimal');
    }

}