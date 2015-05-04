<?php namespace App\Http\Controllers;

use \Illuminate\Support\Facades\Request;
use \App\Http\Models\Field;
use \App\Http\Models\FieldGroup;
use \App\Http\Models\FieldType;

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
        unset($data['settings']);
        return $this->_detailDo(Field::create($data));
    }

    public function detailDo($id) {

        return $this->_detailDo(Field::findOrFail($id));
    }

    private function _detailDo($field) {

        $data = Request::all();
        $data['settings'] = json_encode($data['settings']);

        $saved = $field->update($data);
        return $saved ? redirect()->route('fields') : view('fields.detail');
    }
}
