<?php namespace App\CMS\Services;

use \App\CMS\Models\Channel;

class ChannelService {

    public static function getEntry($handle) {

        return Channel::where('handle', $handle)->firstOrFail()->entry();
    }
}