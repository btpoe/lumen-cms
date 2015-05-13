<?php namespace App\CMS\Models;

class Template extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle',
    ];

    public function fields()
    {
        return $this->belongsToMany('\App\CMS\Models\Field')->withPivot('sort');
    }
}