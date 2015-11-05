<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: start.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-05 13:50
 *  +--------------------------------------------------------------
 *  | Description: start framework
 *  +--------------------------------------------------------------
 */


$currentdir = dirname(__FILE__);
include_once($currentdir . '/include.list.php');

foreach ($paths as $path) {
    include_once($currentdir . '/' . $path);
}

class start
{
    public static $controller;
    public static $method;
    private static $config;

    /**
     * undocumented function
     *
     * @return void
     */
    private static function init_db()
    {
        DB::init(self::$config['dbtype'], self::$config['dbconfig']);
    }
    

} // END class 
