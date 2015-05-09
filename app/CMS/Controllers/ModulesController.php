<?php namespace App\CMS\Controllers;

use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Request;
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

        $appDB = DB::connection('mysql');
        return view('modules.listing', ['handle' => $handle, 'entries' => $appDB->table($handle)->get()]);
    }

    public function add($handle) {

        $module = Module::where('handle', $handle)->firstOrFail();
        $fields = $module->fields()->orderBy('pivot_sort')->get();
        $fieldTypes = [];
        $entry = new \stdClass();
        $entry->title = null;
        foreach($fields as $field) {
            $entry->{$field->handle} = null;
            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
        }
        return view('modules.detail', compact('entry', 'fields', 'fieldTypes'));
    }

    public function addDo($handle) {

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
        $appDB = DB::connection('mysql');
        $saved = $valid && $appDB->table($handle)->insert($data);
        return $saved ? redirect()->route('module-list', ['handle' => $handle]) : view('modules.detail', compact('entry', 'fields', 'fieldTypes'));
    }

    public function detail($id) {

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

    /**
     * @param Module $module
     * @return \Illuminate\View\View
     */
    public function _settings_detail(Module $module) {

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

    public function _settings_detailDo(Module $module, $oldModuleSchema = false) {

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
