<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: start.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-10 16:36
 *  +--------------------------------------------------------------
 *  | Description: start framework
 *  +--------------------------------------------------------------
 */

date_default_timezone_set('PRC');
session_start();
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

    private static function init_db()
    {
        DB::init(self::$config['dbtype'], self::$config['dbconfig']);
    }
    
    private static function init_view()
    {
        VIEW::init('Smarty', self::$config['viewconfig']);
    }
    

    private static function init_controller()
    {
        return self::$controller = isset($_GET['c']) ? straddslashes($_GET['c']) : self::$config['controller'];
    }

    private static function init_method()
    {
        return self::$method = isset($_GET['m']) ? straddslashes($_GET['m']) : self::$config['method'];
    }
    
    

    public static function run($config)
    {
        self::$config = $config;
        foreach (self::$config['paths'] as $path) {
            include_once(self::$config['dir'] . '/' . $path);
        }
        self::init_db();
        self::init_view();
        self::init_controller();
        self::init_method();
        C(self::$controller, self::$method);
    }

} // END class 
