<?php namespace App\Http\Controllers;

use \Illuminate\Support\Facades\Request;
use \App\Http\Models\Module;
use \App\Http\Services\ModuleService;
use \App\Http\Models\Field;
use \App\Http\Models\FieldGroup;

class ModulesController extends Controller
{
    public function index() {

        return view('modules.index', ['modules' => Module::all()]);
    }

    public function add() {

        return $this->_detail(new Module);
    }

    public function addDo() {

        $data = Request::all();
        $module = Module::create($data);
        if($module) {
            ModuleService::generateTable($module);
        }
        return $module ? redirect()->route('modules') : view('modules.detail');
    }

    public function detail($id) {

        return $this->_detail(Module::findOrFail($id));
    }

    /**
     * @param Module $module
     * @return \Illuminate\View\View
     */
    public function _detail(Module $module) {

        $activeFields = $module->fields()->orderBy('pivot_sort')->get();
        $activeFieldsIds = $activeFields->keyBy('id')->keys()->toArray();
        $fields = Field::select('*')->whereNotIn('id', $activeFieldsIds)->get()->groupBy('group_id');
        $fieldGroups = FieldGroup::all();
        return view('modules.detail', compact('module', 'activeFields', 'fields', 'fieldGroups'));
    }

    public function detailDo($id) {

        $data = Request::all();

        $fields = [];

        if (!empty($data['fields'])) {
            foreach($data['fields'] as $sort => $field) {
                $fields[$field] = [
                    'sort' => $sort
                ];
            }
        }

        $module = Module::findOrFail($id);
        $oldModuleSchema = $module->toArray();
        $saved = $module->update($data);
        $module->fields()->sync($fields);
        ModuleService::generateTable($module, $oldModuleSchema);
        return $saved ? redirect()->route('modules') : view('modules.detail');
    }
}
