<?php namespace App\CMS\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

    protected $connection = 'cms_mysql';

    public function scopeHandle($query, $handle) {
        return $query->where('handle', $handle)->first();
    }
}