<?php namespace App\CMS\Models;

class TemplateEntry extends Entry {

    const PREFIX = 'template_';

//    protected $unguarded = true;

    public function __construct(array $attributes = [])
    {
        if (!empty($attributes['table'])) {
            $this->table = self::PREFIX.$attributes['table'];
            unset($attributes['table']);
        }
        parent::__construct($attributes);
    }
}
