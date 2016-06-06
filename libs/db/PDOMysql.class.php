<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: PDOMysql.class.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2016-01-14 17:52
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */


class PDOMysql
{
    private $con = null;

    public function connect($config)
    {
        extract($config);
        $dsn = 'mysql:host=' . $dbhost . ';port=' . $dbport . ';dbname=' . $dbname;
        try {
            $this->con = new PDO($dsn, $dbuser, $dbpwd);
            if(!empty($dbcharset)) {
                $setcharset = 'set names ' . $dbcharset;
                $this->con->exec($setcharset);
            }
            return true;
        } catch (PDOException $e) {
            if($dbdebug) {
                echo $e->getMessage();
            }
            return false;
        }
    }

    public function query($sql, $arr)
    {
        $stmt = $this->con->prepare($sql);
        if(is_array($arr)) {
            foreach ($arr as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function findAll($stmt)
    {
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }

    public function findOne($stmt)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function insert($table, $arr, $insertID)
    {
        $keys = array_keys($arr);
        $fields = $keys;
        array_walk($fields, array('PDOMysql', 'addSpecialChar'));
        $fields = implode(',', $fields);
        $parameters = $keys;
        foreach ($parameters as $key => $value) {
            $parameters[$key] = ':' . $value;
        }
        $parameters = implode(',', $parameters);
        $sql = 'INSERT INTO `' . $table . '` (' . $fields . ') VALUE (' . $parameters . ')';
        $stmt = $this->query($sql, $arr);
        $errorCode = $stmt->errorCode();
        if ($errorCode !== '00000') {
            $errorInfo = $stmt->errorInfo();
            $errorMsg = 'ERROR '. $errorInfo[1] . ' (' . $errorInfo[0] . '):' . $errorInfo[2];
            return $errorMsg;
        } elseif ($insertID) {
            return $this->con->lastInsertId();
        } else {
            return $stmt->rowCount();
        }
    }

    public function update($table, $arr, $where)
    {
        $keys = array_keys($arr);
        $fields = $keys;
        array_walk($fields, array('PDOMysql', 'addSpecialChar'));
        foreach ($keys as $key => $value) {
            $parameters[$key] = $fields[$key] . '=:' . $value;
        }
        $parameters = implode(',', $parameters);
        $sql = 'UPDATE `' . $table . '` SET ' . $parameters . ' WHERE ' . $where;
        $stmt = $this->query($sql, $arr);
        return self::errorMsg($stmt);
    }

    public function del($table, $where)
    {
        $sql = 'DELETE FROM `' . $table . '` WHERE ' . $where;
        $stmt = $this->query($sql, null);
        return self::errorMsg($stmt);
    }
    
    private static function addSpecialChar(&$value)
    {
        if($value !== '*' || strpos($value, '.') === false || strpos($value, '`') === false) {
            $value = '`' . trim($value) . '`';
        }

        return $value;
    }

    private static function errorMsg($stmt)
    {
        $errorCode = $stmt->errorCode();
        if ($errorCode !== '00000') {
            $errorInfo = $stmt->errorInfo();
            $errorMsg = 'ERROR '. $errorInfo[1] . ' (' . $errorInfo[0] . '):' . $errorInfo[2];
            return $errorMsg;
        } else {
            return $stmt->rowCount();
        }
    }
    

    public function qstr($string)
    {
        return $this->con->quote($string);
    }
    
    
}
