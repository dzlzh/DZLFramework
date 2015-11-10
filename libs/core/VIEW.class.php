<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: VIEW.class.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-10 16:28
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */

class VIEW
{
    public static $view;

    /**
     * init
     *
     * @return void
     */
    public static function init($viewtype, $config)
    {
        self::$view = new $viewtype;

        foreach ($config as $key => $value) {
            self::$view->$key = $value;
        }
    }
    
    /**
     * assign
     *
     * @return void
     */
    public static function assign($data)
    {
        foreach ($data as $key=>$value) {
            self::$view->assign($key, $value);
        }
        
    }
    
    /**
     * display
     *
     * @return void
     */
    public static function display($template)
    {
        self::$view->display($template);
    }
    
    
} // END class VIEW
