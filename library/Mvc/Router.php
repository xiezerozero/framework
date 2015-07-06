<?php
/**
 * Router.php
 *
 * PhpStorm
 *
 * @author: xielin
 */
namespace Library\Mvc;


/**
 * Class Router
 *
 * @package Library\Mvc
 */
class Router
{
    /**
     * @var string 根据路由匹配到的controllerName
     */
    private $_controller;

    /**
     * @var string 根据路由匹配到的actionName
     */
    private $_action;

    const DEFAULT_CONTROLLER = 'Index';

    const DEFAULT_ACTION = 'index';


    public function init()
    {
        if (!isset($_GET['_url'])) {
            if (!empty($_SERVER['PATH_INFO'])) {
                //nginx 可能不存在 PATH_INFO
                $_GET['_url'] = $_SERVER['PATH_INFO'];
            } else {
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                $part = strrchr($path, '.php'); //去除index.php 获取路径,用于寻找控制器
                if ($part) {
                    $_GET['_url'] = ltrim($part, '.php');
                } else {
                    //index.php 已经被重写不见了
                    $_GET['_url'] = $path;
                }
            }
        }
        //将路由设置到$_GET['_url']中,eg: /post/add
        $_GET['_url'] = trim($_GET['_url'], '/');   //去除首尾斜杠
        $routes = empty(trim($_GET['_url'])) ? [] : explode('/', $_GET['_url']);  //如果没有任何路由,$_GET['_url']是空字符串
        $this->_controller = isset($routes[0]) ? ucfirst($routes[0]) : self::DEFAULT_CONTROLLER;    //类名首字母大写
        $this->_action = isset($routes[1]) ? $routes[1] : self::DEFAULT_ACTION;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }


}