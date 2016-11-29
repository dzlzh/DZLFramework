<?php

namespace core;

/**
 * Class Config
 */
class Config
{
    private static $config = []; //存放配置

    /**
     * 读取配置
     *
     * @return void
     */
    public static function get($name = null)
    {
        if (empty($name)) {
            return self::$config;
        }
        //若存在配置项，则返回配置值。否则返回 null
        return isset(self::$config[strtolower($name)]) ? self::$config[strtolower($name)] : null;
    }

    /**
     * 动态设置配置
     *
     * @return void
     */
    public static function set($name, $value = null)
    {
        if (is_string($name)) { //字符串，直接设置
            self::$config[strtolower($name)] = $value;
        } elseif (is_array($name)) { //数组，循环设置
            if (!empty($value)) {
                self::$config[$value] = isset(self::$config[$value]) ? array_merge(self::$config[$value], $name) : self::$config[$value] = $name;
            } else {
                return self::$config = array_merge(self::$config, array_change_key_case($name));
            }
        } else { //配置方式错误，返回当前全部配置
            return self::$config;
        }
    }

    /**
     * 判断是否存在配置
     *
     * @return void
     */
    public static function has($name)
    {
        return isset(self::$config[strtolower($name)]);
    }
    
    /**
     * 加载其他配置文件
     *
     * @return void
     */
    public static function load($file)
    {
        if (is_file) {
            $type = pathinfo($file, PATHINFO_EXTENSION);
            if ($type == 'php') {
                return self::set(include $file);
            }
        }
        return self::$config;
    }
}
