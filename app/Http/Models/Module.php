<?php namespace App\Http\Models;

class Module extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle'
    ];

}