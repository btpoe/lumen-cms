<?php namespace App\Http\Controllers;

use \App\Http\Models\Field;
use \App\Http\Models\FieldGroup;
use \App\Http\Models\FieldType;
use \Illuminate\Support\Facades\Request;

class FieldsController extends Controller
{
    public function index() {

        return view('fields.index', ['fields' => Field::all()]);
    }

    public function add() {

        return $this->_detail(Field::find(1)->newInstance());
    }

    public function addDo() {

        $data = Request::all();
        return Field::create($data) ? /*redirect()->route('fields')*/ 'saved' : view('fields.detail');
    }

    public function detail($id) {

        return $this->_detail(Field::findOrFail($id));
    }

    public function _detail($field) {

        $fieldGroups = FieldGroup::all();
        $fieldTypes = FieldType::all();
        return view('fields.detail', compact('field', 'fieldGroups', 'fieldTypes'));
    }

    public function detailDo($id) {

        $data = Request::all();
        $saved = Field::findOrFail($id)->update($data);
        return $saved ? /*redirect()->route('fields')*/ 'saved' : view('fields.detail');
    }
}
