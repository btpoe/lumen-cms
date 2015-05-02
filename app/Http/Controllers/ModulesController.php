<?php namespace App\Http\Controllers;

use \Illuminate\Support\Facades\Request;
use \App\Http\Models\Module;

class ModulesController extends Controller
{
    public function index() {

        return view('modules.index', ['modules' => Module::all()]);
    }

    public function add() {

        return view('modules.detail', ['module' => Module::find(1)->newInstance()]);
    }

    public function addDo() {

        $data = Request::all();
        return Module::create($data) ? redirect()->route('modules') : view('modules.detail');
    }

    public function detail($id) {

        return view('modules.detail', ['module' => Module::findOrFail($id)]);
    }

    public function detailDo($id) {

        $data = Request::all();
        $saved = Module::findOrFail($id)->update($data);
        return $saved ? redirect()->route('modules') : view('modules.detail');
    }
}
