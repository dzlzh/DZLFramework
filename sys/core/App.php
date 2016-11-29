<?php

namespace core;

use core\Config;
use core\Router;
/**
 * Class App
 */
class App
{

    public static $router; //定义一个静态路由实例

    /**
     * 启动
     *
     * @return void
     */
    public static function run()
    {
        self::$router = new Router(); //实例化路由类
        self::$router->setUrlType(Config::get('url_type')); //读取配置并设置路由类型

        $url_array = self::$router->getUrlArray(); //获取经过路由类生成的路由数组

        self::dispatch($url_array); //根据路由数组分发路由
    }

    /**
     * 路由分发
     *
     * @return void
     */
    public static function dispatch($url_array = [])
    {
        $module = '';
        $controller = '';
        $action = '';

        if (isset($url_array['module'])) { //若路由中存在 module,则设置当前模块
            $module = $url_array['module'];
        } else { //不存在,则设置默认的模块
            $module = Config::get('default_module');
        }

        if (isset($url_array['controller'])) { //若路由中存在 controller,则设置当前控制器,首字母大写
            $controller = ucfirst($url_array['controller']);
        } else {
            $controller = ucfirst(Config::get('default_controller'));
        }
        
        //拼接控制器文件路径
        $controller_file = APP_PATH . $module . DS . 'controller' . DS . $controller . 'Controller.php';

        if (isset($url_array['action'])) {
            $action = $url_array['action'];
        } else {
            $action = Config::get('default_action');
        }

        //判断控制器文件是否存在
        if (file_exists($controller_file)) {
            //引入该控制器,并实例化
            require $controller_file;
            $className = 'module\controller\IndexController';
            $className = str_replace('module', $module, $className);
            $className = str_replace('IndexController', $controller . 'Controller', $className);
            $controller = new $className;

            //判断访问方法是否存在
            if (method_exists($controller, $action)) {
                $controller->setTpl($action); //设置方法对应的视图模
                $controller->$action(); //执行该方法
            } else {
                die('The method does not exist');
            }
        } else {
            die('The controller does not exist');
        }
    }
}
