<?php namespace App\CMS\Controllers;

use \App\CMS\Models\Channel;

class ChannelsController extends Controller
{
    public function index() {

        return view('channels.index', ['channels' => Channel::all()]);
    }

    public function add() {

        return view('channels.add');
    }

    public function detail($id = null) {

        $channel = !empty($id) ? Channel::findOrFail($id) : null;
        return view('channels.detail', compact('channel'));
    }
}