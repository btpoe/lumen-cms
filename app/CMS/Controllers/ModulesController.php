<?php namespace App\CMS\Controllers;

use \DB;
use \Request;
use \Schema;
use \App\CMS\Models\Module;
use \App\CMS\Services\ModuleService;
use \App\CMS\Models\Field;
use \App\CMS\Models\FieldGroup;

class ModulesController extends Controller
{
    public function index() {

        return view('modules.index', ['modules' => Module::all()]);
    }

    public function listing($handle) {

        return view('modules.listing', ['handle' => $handle, 'entries' => DB::table($handle)->get()]);
    }

    public function add($handle) {

        $entry = new \stdClass();
        $cols = Schema::getColumnListing($handle);
        $entry->title = null;
        foreach($cols as $col) {
            $entry->{$col} = null;
        }

        return $this->_detail($handle, $entry);
    }

    public function detail($handle, $id) {

        return $this->_detail($handle, DB::table($handle)->find($id));
    }

    private function _detail($handle, $entry) {

        $module = Module::where('handle', $handle)->firstOrFail();
        $fields = $module->fields()->orderBy('pivot_sort')->get();
        $fieldTypes = [];
        foreach($fields as $field) {
            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
        }
        return view('modules.detail', compact('entry', 'fields', 'fieldTypes'));
    }

    public function addDo($handle) {

        return $this->detailDo('foo', $handle);
    }

    public function detailDo($foo, $handle, $id = false) {

        $data = Request::all();
        $module = Module::where('handle', $handle)->firstOrFail();
        $fields = $module->fields()->orderBy('pivot_sort')->get();
        $fieldTypes = [];
        $valid = false;
        $fieldTypes[PLAIN_TEXT_ID] = app()->make('\App\CMS\FieldTypes\PlainText');
        $data['title'] = $fieldTypes[PLAIN_TEXT_ID]->validate($data['title'], ['maxlength' => 255]);
        foreach($fields as $field) {
            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
            $data[$field->handle] = $fieldTypes[$field->type_id]->validate($data[$field->handle], json_decode($field->settings, true));
            if (!$valid = !!$data[$field->handle]) {
                break;
            }
        }
        if ($id) {
            $saved = $valid && DB::table($handle)->where('id', $id)->update($data);
        }
        else {
            $saved = $valid && DB::table($handle)->insert($data);
        }
        return $saved ? redirect()->route('module-list', ['handle' => $handle]) : view('modules.detail', compact('entry', 'fields', 'fieldTypes'));
    }

    public function settings_index() {

        return view('modules.settings_index', ['modules' => Module::all()]);
    }

    public function settings_add() {

        return $this->_settings_detail(new Module);
    }

    public function settings_detail($id) {

        return $this->_settings_detail(Module::findOrFail($id));
    }

    private function _settings_detail(Module $module) {

        $activeFields = $module->fields()->orderBy('pivot_sort')->get();
        $activeFieldsIds = $activeFields->keyBy('id')->keys()->toArray();
        $fields = Field::select('*')->whereNotIn('id', $activeFieldsIds)->get()->groupBy('group_id');
        $fieldGroups = FieldGroup::all();
        return view('modules.settings_detail', compact('module', 'activeFields', 'fields', 'fieldGroups'));
    }

    public function settings_addDo() {

        $data = Request::all();
        $module = Module::create($data);
        return $this->_settings_detailDo($module);
    }

    public function settings_detailDo($id) {

        $module = Module::findOrFail($id);
        $oldModuleSchema = $module->toArray();
        return $this->_settings_detailDo($module, $oldModuleSchema);
    }

    private function _settings_detailDo(Module $module, $oldModuleSchema = false) {

        $data = Request::all();

        $fields = [];

        if (!empty($data['fields'])) {
            foreach($data['fields'] as $sort => $field) {
                $fields[$field] = [
                    'sort' => $sort
                ];
            }
        }

        $saved =    $module->update($data) &&
                    $module->fields()->sync($fields) &&
                    ModuleService::generateTable($module, $oldModuleSchema);

        return $saved ? redirect()->route('settings-modules') : view('modules.settings_detail');

    }
}
