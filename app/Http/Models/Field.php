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
        return $this->belongsTo('\App\Http\Models\FieldGroup');
    }
    public function type()
    {
        return $this->belongsTo('\App\Http\Models\FieldType');
    }

    public function modules() {
        return $this->belongsToMany('\App\Http\Models\Module');
    }
}