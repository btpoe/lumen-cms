<?php namespace App\CMS\Models;

class Module extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle'
    ];

    public function fields()
    {
        return $this->belongsToMany('\App\CMS\Models\Field')->withPivot('sort');
    }

    public function entry($id) {
        $entryModel = new ModuleEntry(['table' => $this->handle]);
        return $entryModel->find($id);
    }

    public function entries()
    {
        $entryModel = new ModuleEntry(['table' => $this->handle]);
        return $entryModel->get();
    }

    public function getEntriesAttribute() {
        return $this->entries();
    }
}