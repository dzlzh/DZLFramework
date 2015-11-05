<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: function.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-05 15:14
 *  +--------------------------------------------------------------
 *  | Description: function
 *  +--------------------------------------------------------------
 */


function straddslashes($str)
{
    return (!get_magic_quotes_gpc()) ? addslashes($str) : $str;
}

function C($name, $method)
{
    require_once('libs/Controller/' . $name . 'Controller.class.php');
    $name .= 'Controller';
    $obj = new $name();
    $obj->$method();
}

function M($name)
{
    require_once('libs/Model/' . $name . 'Model.class.php');
    $name .= 'Model';
    $obj = new $name();
    return $obj;
}

function V($name)
{
    require_once('libs/View/' . $name . 'View.class.php');
    $name .= 'View';
    $obj = new $name();
    return $obj;
}

function ORG($path, $name, $params = array())
{
    require_once('libs/ORG/' . $path . $name . '.class.php');
    $obj = new $name;

    if (!empty($params)) {
        foreach ($params as $key=>$value) {
            $obj->$key = $value;
        }
        
    }

    return $obj;
}

