<?php namespace App\Cms\Services;

class CmsService {

    public static function getChannelEntry($handle) {
        return ChannelService::getEntry($handle);
    }
}