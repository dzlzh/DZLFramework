<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: mysql.class.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-05 11:42
 *  +--------------------------------------------------------------
 *  | Description: mysql class
 *  +--------------------------------------------------------------
 */


class mysql
{

    public $displayError = false;

    /**
     *  error   终止并输出错误
     *
     *  @param  string $error
     *  @return null
     */
    function error($error)
    {
        if($this->displayError) {
            die("error: " . $error);
        }

        return false;
    }

    /**
     *  数据库连接
     *
     *  @param  string $dbhost     主机名
     *  @param  string $dbuser     用户名
     *  @param  string $dbpwd      密码
     *  @param  string $dbname     数据库名
     *  @param  string $dbcharset  字符编码
     *  @param  string $dbdebug      错误调试
     *  @return bool   连接成功或不成功
     */
    function connect($config)
    {
        extract($config);

        if (!empty($dbdebug)) {
            $this->displayError = true;
        }

        if (!($con = mysql_connect($dbhost, $dbuser, $dbpwd))) {
            return $this->error(mysql_error());
        }

        if (!mysql_select_db($dbname, $con)) {
            return $this->error(mysql_error());
        }
        if (!empty($dbcharset)) {
            mysql_query("set name " . $dbcharset);
        }
        return true;
    }

    /**
     *  执行sql语句
     *
     *  @param  string $sql sql语句
     *  @return 成功返回资源，失败返回false
     */
    function query($sql)
    {
        if (!($query = mysql_query($sql))) {
            return $this->error($sql . "\n" . mysql_error());
        } else {
            return $query;
        }
    }

    /**
     *  返回结果集中所有数据
     *
     *  @param  $query       资源
     *  @return array $list  结果集关联数组
     */
    function findAll($query)
    {
        while ($res = mysql_fetch_array($query, MYSQL_ASSOC)) {
            $list[] = $res;
        }

        return isset($list) ? $list : "";
    }

    /**
     *  返回结果集中单条数据
     *
     *  @param  $query       资源
     *  @return array $list  单条结果关联数组
     */
    function findOne($query)
    {
        $res = mysql_fetch_array($query, MYSQL_ASSOC);
        return $res;
    }


    /**
     *  插入
     *
     *  @param  string $table  表名
     *  @param  array  $arr    插入数组
     *  @return int    成功返回产生的ID,失败返回0
     */
    function insert($table, $arr, $insertId)
    {
        foreach ($arr as $key=>$value) {
            $value = mysql_real_escape_string($value);
            $keyArr[] = "`" . $key . "`";
            $valueArr[] = "'" . $value . "'";
        }

        $keys = implode(",", $keyArr);
        $values = implode(",", $valueArr);
        $sql = "INSERT INTO " . $table . "(" . $keys . ") VALUES(" . $values . ")";
        if ($insertId) {
            return $this->query($sql) ? mysql_insert_id() : false;
        } else {
            return $this->query($sql);
        }
        
        $this->query($sql);
        return mysql_insert_id();

    }

    /**
     *  修改
     *
     *  @param  string $table 表名
     *  @param  array  $arr   修改数组
     *  @param  string $where 修改条件
     *  @return bool   修改是否成功
     */
    function update($table, $arr, $where)
    {
        foreach ($arr as $key=>$value) {
            $value = mysql_real_escape_string($value);
            $keyAndValueArr[] = "`" . $key . "` = '" . $value . "'";
        }

        $keyAndValues = implode(",", $keyAndValueArr);
        $sql = "UPDATE " . $table . " SET " . $keyAndValues;

        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }

        return $this->query($sql);
    }

    /**
     *  删除
     *
     *  @param  string $table 表名
     *  @param  string $where 删除条件
     *  @return 删除是否成功
     */
    function del($table, $where)
    {
        $sql = "DELETE FROM " . $table;
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }

        return $this->query($sql);
    }

} // END class mysql
