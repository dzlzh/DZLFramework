<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: adodb.class.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-14 19:34
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */


class adodb
{

    private $con;

    public function connect($config)
    {
        extract($config);
        $this->con = NewADOConnection('pdo');
        $this->con->debug = $dbdebug;
        return $this->con->Connect('mysql:host=' . $dbhost, $dbuser, $dbpwd, $dbname);
    }

    public function query($sql, $arr)
    {
        return $this->con->Execute($sql, $arr);
    }

    public function findAll($data)
    {
        return $data->GetAll();
    }

    public function findOne($data)
    {
        $data = $data->GetRows();
        return $data[0];
    }

    public function insert($table, $arr, $insertId)
    {
        return $this->con->AutoExecute($table, $arr, 'INSERT');
    }
    
    public function update($table, $arr, $where)
    {
        return $this->con->AutoExecute($table, $arr, 'UPDATE', $where);
    }

    public function qstr($string)
    {
        return $this->con->qstr($string);
    }
    
    
    
} // END class adodb
