<?php namespace App\CMS\Models;

class Module extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle'
    ];

    protected $moduleEntryModel;

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->moduleEntryModel = new ModuleEntry([], $this->handle);
    }

    public function fields()
    {
        return $this->belongsToMany('\App\CMS\Models\Field')->withPivot('sort');
    }

    public function entry($id)
    {
        return $this->moduleEntryModel->find($id);
    }

    public function entries()
    {
        return $this->moduleEntryModel->get();
    }

    public function getEntriesAttribute()
    {
        return $this->entries();
    }
}