<?php namespace App\CMS\Models;

class Single extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle',
        'template_id'
    ];

    protected $with = ['template'];

    public function template()
    {
        return $this->belongsTo('\App\CMS\Models\Template');
    }

    public function entry()
    {
        if (empty($this->template_id)) {
            return null;
        }

        $query = \DB::connection('mysql')->table(TemplateEntry::PREFIX.$this->template->handle);
        $entryAttributes = $query->where('single_id', $this->id)->first();

        if (empty($entryAttributes)) {
            $entryId = $query->insertGetId($entryAttributes = ['single_id' => $this->id]);
            $entryAttributes['id'] = $entryId;
        }

        $entry = new TemplateEntry((array) $entryAttributes);
        $entry->setTable($this->template->handle);
        $entry->exists = true;
        return $entry;
    }

    public function getEntryAttribute() {
        return $this->entry();
    }
}