<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: DB.class.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-05 11:35
 *  +--------------------------------------------------------------
 *  | Description:  DB class
 *  +--------------------------------------------------------------
 */

class DB 
{
    public static $db;

    public static function init($dbtype, $config)
    {
        self::$db = new $dbtype;
        self::$db->connect($config);
    }

    public static function query($sql)
    {
        return self::$db->query($sql);
    }

    public static function findAll($sql)
    {
        $query = self::$db->query($sql);
        return self::$db->findAll($query);
    }

    public static function findOne($sql)
    {
        $query = self::$db->query($sql);
        return self::$db->findOne($query);
    }
    
    public static function insert($table, $arr, $insertId = true)
    {
        return self::$db->insert($table, $arr, $insertId);
    }

    public static function update($table, $arr, $where = null)
    {
        return self::$db->update($table, $arr, $where);
    }
    
    public static function del($table, $where = null)
    {
        return self::$db->del($table, $where);
    }
    
    
} // END class 

