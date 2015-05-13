<?php namespace App\CMS\Models;

class Single extends Model {

    protected $guarded = [];
    protected $fillable = [
        'title',
        'handle',
        'template_id',
        'entry_id'
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

        if (empty($this->entry_id)) {
            $entry = \DB::connection('mysql')
                ->table(TemplateEntry::PREFIX.$this->template->handle)->insert([]);
            $this->entry_id = $entry->id;
            $this->save();
        }

        $entryModel = new TemplateEntry(['table' => $this->template->handle]);
        return $entryModel->where('id', '=', $this->entry_id)->first();
    }

    public function getEntryAttribute() {
        return $this->entry();
    }
}