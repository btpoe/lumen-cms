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

        $templateEntryModel = new TemplateEntry([], $this->template->handle);

        $entry = $templateEntryModel->where('single_id', $this->id)->first();

        if (count($entry)) {
            $entryId = \DB::connection(TemplateEntry::CONNECTION)->table(TemplateEntry::PREFIX.$this->template->handle)
                ->insertGetId($entryAttributes = ['single_id' => $this->id]);
            $entryAttributes['id'] = $entryId;
            $entry = new TemplateEntry($entryAttributes, $this->template->handle);
            $entry->exists = true;
        }

        $entry->setTable($this->template->handle);
        return $entry;
    }

    public function getEntryAttribute() {
        return $this->entry();
    }
}