<?php namespace App\CMS\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

    protected $connection = 'cms_mysql';
}