<?php namespace App\Http\Models;

class Field extends Model {

    protected $guarded = [];
    protected $fillable = [
        'group_id',
        'title',
        'handle',
        'instructions',
        'type_id',
        'settings'
    ];

    public function group()
    {
        return $this->hasOne('FieldGroup');
    }
    public function type()
    {
        return $this->hasOne('FieldType');
    }
}