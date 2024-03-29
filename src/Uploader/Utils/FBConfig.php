<?php

namespace Uploader\Utils;

/**
 * Utility class for storing App constants etc.
 * Class FBConfig
 * @package Uploader
 */
class FBConfig {
    const APP_ID = '1409910789303690';
    const APP_SECRET = '161ca6547ad7742302bba61a5c152f54';
    const HOST_ROOT = 'http://fb.samdlc.com/';
    private static $permissions = array (
        'email',
        'publish_actions');
    
    static function getPermissions() {
        return self::$permissions;
    }
}