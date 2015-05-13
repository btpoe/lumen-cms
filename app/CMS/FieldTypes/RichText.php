<?php namespace App\CMS\FieldTypes;

class RichText extends FieldType {

    public function __construct()
    {
        $this->Number = new Number();
        $this->Checkboxes = new Checkboxes();
    }

    protected function _config()
    {
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

    protected function _process(array $settings = [])
    {
        return $settings;
    }

}