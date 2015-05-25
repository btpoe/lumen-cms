<?php namespace App\Http\Services;

use App\CMS\Services\ModuleService as CmsModuleService;

class ModuleService extends CmsModuleService {

    protected $manifest = [
        'cars' => 'Car',
        'bikes' => 'Bike',
    ];

    protected $adminManifest = [
        'people' => 'Person'
    ];
}