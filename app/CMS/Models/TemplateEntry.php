<?php namespace App\CMS\Models;

class TemplateEntry extends Entry {

    const PREFIX = 'template_';

    protected $guarded = [];

    public function setTable($table) {
        $this->table = self::PREFIX.$table;
        $fillable = array_slice(\Schema::getColumnListing($this->table), 2);
        $this->fillable = $fillable;
    }
}
