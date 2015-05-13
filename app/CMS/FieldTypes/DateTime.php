<?php namespace App\CMS\FieldTypes;

class DateTime extends FieldType {

    public function __construct()
    {
        $this->Radios = new Radios();
        $this->Dropdown = new Dropdown();
    }

    protected function _config()
    {
        $output  = "";
        $output .= $this->Radios->render('show', [
            'options' => [
                'date' => 'Show date',
                'time' => 'Show time',
                'datetime' => 'Show date and time'
            ],
            'value' => 'date'
        ]);
        $output .= $this->Dropdown->render('increment', [
            'options' => [
                5 => '5',
                15 => '15',
                30 => '30'
            ]
        ]);
        return $output;
    }

    protected function _process(array $settings = [])
    {
        return $settings;
    }

}