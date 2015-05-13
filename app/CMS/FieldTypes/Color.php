<?php namespace App\CMS\FieldTypes;

class Color extends FieldType {

    protected function _config()
    {
        return 'No config settings.';
    }

    protected function _process(array $settings = [])
    {
        return $settings;
    }

}