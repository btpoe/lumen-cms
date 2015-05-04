<?php namespace App\Http\Models;

class Module extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle'
    ];

    public function fields() {
        return $this->belongsToMany('\App\Http\Models\Field')->withPivot('sort');
    }

}