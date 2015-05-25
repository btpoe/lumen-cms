<?php namespace App\CMS\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\CMS\Models\Module;

class Controller extends BaseController
{
    public function __construct() {
        $this->moduleService = app('\App\Http\Services\ModuleService');
        view()->share('modules', $this->moduleService->getManifest());
    }
}
