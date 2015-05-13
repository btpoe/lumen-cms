<?php namespace App\CMS\FieldTypes;

class Radios extends FieldType {

    public function __construct()
    {
        $this->Table = new Table();
    }

    protected function _config()
    {
        $output  = "";
        $output .= $this->Table->render('options', [
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

    protected function _process(array $settings = [])
    {
        return $settings;
    }

    protected function fillOptions($field, $params)
    {
        $options = [];
        foreach($params['options'] as $key => $option) {
            if (!is_array($option)) {
                $option = [
                    'title' => $option,
                    'value' => $key
                ];
            }
            $option['checked'] = isset($params['value']) && $params['value'] === $option['value'] ? 'checked' : '';
            $options[] = $option;
        }
        return parent::fillOptions($field, $params) + compact('options');
    }

}