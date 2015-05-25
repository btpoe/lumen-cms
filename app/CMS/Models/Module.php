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

    public function entryTitle($withPrefix = false) {
        $prefix = '';
        if ($withPrefix) {
            $firstCharacter = strtolower(substr($this->title, 0, 1));
            $prefix = in_array($firstCharacter, ['a', 'e', 'i', 'o', 'u']) ? 'an ' : 'a ';
        }
        return $prefix . \Doctrine\Common\Inflector\Inflector::singularize($this->title);
    }

    public function getEntryTitleAttribute()
    {
        return $this->entryTitle();
    }
    public function getEntryTitleWithPrefixAttribute()
    {
        return $this->entryTitle(true);
    }
}