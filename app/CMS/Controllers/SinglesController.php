<?php namespace App\CMS\Controllers;

use \DB;
use \Request;
use \App\CMS\Models\Single;
use \App\CMS\Models\Template;

class SinglesController extends Controller
{
    public function index() {

        return view('singles.index', ['singles' => Single::all()]);
    }

    public function add() {

        return $this->_detail(new Single);
    }

    public function detail($id) {

        return $this->_detail(Single::findOrFail($id));
    }

    private function _detail($single) {

        $templates = Template::all();
        $entry = $single->entry;
        if (!empty($entry)) {
            $entry = $entry->toArray();
            unset($entry['id']);
            $entrySettings = json_encode($entry);
        }
        else {
            $entrySettings = '[]';
        }
        return view('singles.detail', compact('single', 'templates', 'entrySettings'));
    }

    public function addDo() {

        $data = Request::all();
        return $this->_detailDo(Single::create($data));
    }

    public function detailDo($id) {

        return $this->_detailDo(Single::findOrFail($id));
    }

    private function _detailDo($single) {

        $data = Request::all();
        $template = Template::find($data['template_id']);
        $fields = $template->fields()->orderBy('pivot_sort')->get();
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

        $saved = $valid && $single->update($data);
        if ($saved) $data['single_id'] = $single->id;
        $saved = $saved && $single->entry->update($data);
        return $saved ? redirect()->route('singles') : view('singles.detail', compact('single'));
    }
}
