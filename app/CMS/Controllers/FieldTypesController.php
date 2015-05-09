<?php namespace App\CMS\Controllers;

use \Illuminate\Http\Request;
use \App\CMS\Models\FieldType;

class FieldTypesController extends Controller
{
    public function index() {

        return view('field_types.index', ['fieldTypes' => FieldType::all()->where('is_core', '0')]);
    }

    public function add() {

        return $this->_detail(new FieldType);
    }

    public function detail($id) {

        return $this->_detail(FieldType::findOrFail($id));
    }

    private function _detail($fieldType) {

        return view('field_types.detail', compact('fieldType'));
    }

    public function addDo() {

        $data = Request::all();
        return $this->_detailDo(FieldType::create($data));
    }

    public function detailDo($id) {

        return $this->_detailDo(FieldType::findOrFail($id));
    }

    private function _detailDo($fieldType) {

        $data = Request::all();
        $saved = $fieldType->update($data);
        return $saved ? redirect()->route('settings-field-types') : view('field_types.detail');
    }

    public function config($id) {

        $fieldType = FieldType::findOrFail($id);
        return app('\App\CMS\FieldTypes\\'.$fieldType->handle)->config();
    }
}
