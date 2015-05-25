<?php namespace App\Http\Models;

class Bike extends Model {

    public $fillable = [
        'title',
        'color',
        'people',
        'new_field'
    ];
}