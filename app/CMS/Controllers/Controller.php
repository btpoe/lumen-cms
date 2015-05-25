<?php namespace App\CMS\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\CMS\Models\Module;

class Controller extends BaseController
{
    public function __construct() {
        view()->share('modules', Module::orderBy('title')->get());
    }
}
