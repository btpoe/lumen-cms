<?php namespace App\CMS\Models;

class ModuleEntry extends Entry {

    public function __construct(array $attributes = [])
    {
        if (!empty($attributes['table'])) {
            $this->table = $attributes['table'];
            unset($attributes['table']);
        }
        parent::__construct($attributes);
    }
}
