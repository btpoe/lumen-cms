<?php namespace App\CMS\Controllers;

use \Request;
use \App\CMS\Models\Field;
use \App\CMS\Models\FieldGroup;
use \App\CMS\Models\FieldType;

class FieldsController extends Controller
{
    public function index() {

        return view('fields.index', ['fields' => Field::all()]);
    }

    public function add() {

        return $this->_detail(new Field);
    }

    public function detail($id) {

        return $this->_detail(Field::findOrFail($id));
    }

    private function _detail($field) {

        $fieldGroups = FieldGroup::all();
        $fieldTypes = FieldType::all();
        return view('fields.detail', compact('field', 'fieldGroups', 'fieldTypes'));
    }

    public function addDo() {

        $data = Request::all();
        return $this->_detailDo(Field::create($data));
    }

    public function detailDo($id) {

        return $this->_detailDo(Field::findOrFail($id));
    }

    private function _detailDo($field) {

        // get all settings
        $settings = Request::all();

        // store settings that can't be modified by field types
        $data['title'] = $settings['title'];
        $data['handle'] = $settings['handle'];
        $data['instructions'] = $settings['instructions'];
        $data['type_id'] = $settings['type_id'];
        $data['group_id'] = $settings['group_id'];

        // field type doesn't need to know it's type_id
        unset($settings['group_id'], $settings['type_id']);

        // get field type model
        $fieldType = FieldType::find($data['type_id']);
        // digest settings (return false if invalid)
        $settings = app()->make('\App\CMS\FieldTypes\\'.$fieldType->handle)->process($settings);

        // remove primary settings to reduce bloat
        unset($settings['title'], $settings['handle'], $settings['instructions']);
        $data['settings'] = json_encode($settings);

        // don't update if settings returned false
        $saved = $settings && $field->update($data);

        // redirect if successful, otherwise, show detail page with errors
        return $saved ? redirect()->route('settings-fields') : view('fields.detail')->withErrors(['Please review and fix any mistakes.']);
    }
}
