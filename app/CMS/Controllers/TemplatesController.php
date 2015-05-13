<?php namespace App\CMS\Controllers;

use \DB;
use \Request;
use \Schema;
use \App\CMS\Models\Template;
use \App\CMS\Services\TemplateService;
use \App\CMS\Models\Field;
use \App\CMS\Models\FieldGroup;

class TemplatesController extends Controller
{

    public function settings_index() {

        return view('templates.settings_index', ['templates' => Template::all()]);
    }

    public function settings_add() {

        return $this->_settings_detail(new Template);
    }

    public function settings_detail($id) {

        return $this->_settings_detail(Template::findOrFail($id));
    }

    private function _settings_detail(Template $template) {

        $activeFields = $template->fields()->orderBy('pivot_sort')->get();
        $activeFieldsIds = $activeFields->keyBy('id')->keys()->toArray();
        $fields = Field::select('*')->whereNotIn('id', $activeFieldsIds)->get()->groupBy('group_id');
        $fieldGroups = FieldGroup::all();
        return view('templates.settings_detail', compact('template', 'activeFields', 'fields', 'fieldGroups'));
    }

    public function settings_addDo() {

        $data = Request::all();
        $template = Template::create($data);
        return $this->_settings_detailDo($template);
    }

    public function settings_detailDo($id) {

        $template = Template::findOrFail($id);
        $oldTemplateSchema = $template->toArray();
        return $this->_settings_detailDo($template, $oldTemplateSchema);
    }

    private function _settings_detailDo(Template $template, $oldTemplateSchema = false) {

        $data = Request::all();

        $fields = [];

        if (!empty($data['fields'])) {
            foreach($data['fields'] as $sort => $field) {
                $fields[$field] = [
                    'sort' => $sort
                ];
            }
        }

        $saved =    $template->update($data) &&
            $template->fields()->sync($fields) &&
            TemplateService::generateTable($template, $oldTemplateSchema);

        return $saved ? redirect()->route('settings-templates') : view('templates.settings_detail');

    }

    public function config($id) {

        $template = Template::findOrFail($id);
        $fields = $template->fields()->orderBy('pivot_sort')->get();
        $fieldTypes = [];
        $fieldTypes[PLAIN_TEXT_ID] = app()->make('\App\CMS\FieldTypes\PlainText');
        foreach($fields as $field) {
            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
        }
        return view('templates.config', compact('fields', 'fieldTypes'));
    }
}
