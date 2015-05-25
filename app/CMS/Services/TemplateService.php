<?php namespace App\CMS\Services;

class TemplateService extends DynamicService {

    protected $modelClassName = 'App\CMS\Models\Template';

    protected $tablePrefix = 'template_';

    protected $constantFields = [
        'single_id' => 'int'
    ];

}