<?php namespace App\Http\Models;

class Car extends Model {

    public $fillable = [
        'title',
        'name',
        'people',
        'new_field'
    ];
}