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

    public function addDo() {

        $data = Request::all();
        $module = Module::create($data);
        return $this->_detailDo($module);
    }

    public function detailDo($id) {

        $module = Module::findOrFail($id);
        $oldModuleSchema = $module->toArray();
        return $this->_detailDo($module, $oldModuleSchema);
    }

    public function _detailDo(Module $module, $oldModuleSchema = false) {

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

        return $saved ? redirect()->route('modules') : view('modules.detail', [$module->id]);

    }
}
