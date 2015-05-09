<?php namespace App\CMS\Controllers;

use \App\CMS\Models\Template;

class TemplatesController extends Controller
{
    public function index() {

        return view('templates.index', ['templates' => Template::all()]);
    }

    public function detail($id = null) {

        $template = !empty($id) ? Template::findOrFail($id) : null;
        return view('templates.detail', compact('template'));
    }
}
