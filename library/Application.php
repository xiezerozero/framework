<?php
/**
 * Application.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;

use Library\DI\Injectable;

/**
 * Class Application
 *
 * @package Library
 */
class Application extends Injectable
{

    /**
     * 处理请求,执行指定的action
     *
     * @throws \Exception
     */
    public function handle()
    {
        $this->router->init();
        //获取controller 和 action名字
        $controllerName = $this->router->getController();
        $actionName = $this->router->getAction();
//        $this->template->init($controllerName, $actionName);
        $this->dispatcher->setController($controllerName);
        $this->dispatcher->setAction($actionName);
        $this->dispatcher->dispatch();
    }


} 