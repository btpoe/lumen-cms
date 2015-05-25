<?php namespace App\CMS\Models;

use \Schema;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Entry extends EloquentModel {

    const PREFIX = '';
    const CONNECTION = 'mysql';
    protected $connection = 'mysql';

    public function __construct(array $attributes = [], $table = false)
    {
        if ($table) {
            $this->setTable($table);
        }
        parent::__construct($attributes);
    }

    public function setTable($table) {
        $this->table = $this::PREFIX.$table;
        $fillable = array_slice(Schema::getColumnListing($this->table), 2);
        $this->fillable = $fillable;
    }
}
