<?php namespace App\CMS\Controllers;

use \DB;
use \Request;
use \App\CMS\Models\Module;
use \App\CMS\Models\Field;
use \App\CMS\Models\FieldGroup;

class ModulesController extends Controller
{
    public function __construct() {
        parent::__construct();

        $routeParams = app('request')->route()[2];
        if (!empty($routeParams['handle']))
        {
            $this->moduleService->setModuleByHandle($routeParams['handle']);
        }
    }

    public function index() {

        return view('modules.index');
    }

    public function listing($handle) {

        $module = $this->moduleService->getFacade();
        $entries = $this->moduleService->getModelInstance()->all();

        return view('modules.listing', compact('module', 'entries'));
    }

    public function detail($handle, $id = null) {

        $entry = $this->moduleService->getModelInstance()->findOrNew($id);

        $module = $this->moduleService->getFacade();
        $fields = $this->moduleService->getModelFields();
        $fieldTypes = [];
        foreach($fields as $field) {
            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
        }
        return view('modules.detail', compact('module', 'entry', 'fields', 'fieldTypes'));
    }

    public function detailDo($foo, $handle, $id = false) {

        $data = Request::all();
        $fields = $this->moduleService->getModelFields();
        $fieldTypes = [];
        $valid = false;
        foreach($fields as $field) {
            if (empty($data[$field->handle])) continue;

            if (empty($fieldTypes[$field->type_id])) {
                $fieldTypes[$field->type_id] = app()->make('\App\CMS\FieldTypes\\'.$field->type->handle);
            }
            $data[$field->handle] = $fieldTypes[$field->type_id]->validate($data[$field->handle], json_decode($field->settings, true));
            if (!$valid = !!$data[$field->handle]) {
                break;
            }
        }
        if ($id) {
            $saved = $valid && $this->moduleService->getModelInstance()->find($id)->update($data);
        }
        else {
            $saved = $valid && $this->moduleService->getModelInstance()->create($data);
        }
        return $saved ? redirect()->route('module-list', ['handle' => $handle]) : view('modules.detail', compact('entry', 'fields', 'fieldTypes'));
    }
}
