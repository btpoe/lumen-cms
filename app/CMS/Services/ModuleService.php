<?php namespace App\CMS\Services;

class ModuleService extends DynamicService {

    protected $modelClassName = 'App\CMS\Models\Module';

    protected $constantFields = [
        'title' => 'string'
    ];

}