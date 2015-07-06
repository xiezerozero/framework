<?php
/**
 * Dispatcher.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;


use Library\DI\DiContainer;
use Library\DI\InjectionAwareInterface;
use Library\Mvc\Controller;

/**
 * Class Dispatcher
 *
 * @package Library
 */
class Dispatcher implements InjectionAwareInterface
{

    /** @var DiContainer */
    protected $_di;

    protected $_controller;

    protected $_action;

    protected $_params;

    protected $_defaultNamespace;

    protected $_controllerSuffix = 'Controller';

    protected $_actionSuffix = 'Action';

    protected $_returnValue;

    protected $_previousHandlerName;

    protected $_previousActionName;

    /**
     * sets the dependency injector
     *
     * @param DiContainer $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->_di = $dependencyInjector;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return DiContainer
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * 设置默认的控制器命名空间
     *
     * @param $namespace
     */
    public function setDefaultNamespace($namespace)
    {
        $this->_defaultNamespace = $namespace;
    }

    /**
     * @throws \Exception
     */
    public function dispatch()
    {
        /** 访问控制器一定要设置默认的控制器命名空间 */
        $controllerClass = $this->_defaultNamespace . '\\' . $this->_controller . $this->_controllerSuffix;
        $action = $this->_action . $this->_actionSuffix;
        if (!class_exists($controllerClass, true)) {
            throw new \Exception("can not find controller {$controllerClass}");
        }

        /** @var Controller $controller */
        $controller = new $controllerClass($this->_di); //  todo  forward的时候,如果是同一个控制器的话,不需要实例化
        if (!method_exists($controller, $action)) {
            throw new \Exception("controller {$controllerClass} does not have action {$this->_action}");
        }
        $controller->beforeAction();
        $controller->$action();
        $controller->afterAction();
    }

    /**
     * @return string
     */
    public function getControllerSuffix()
    {
        return $this->_controllerSuffix;
    }

    /**
     * @param string $controllerSuffix
     */
    public function setControllerSuffix($controllerSuffix)
    {
        $this->_controllerSuffix = $controllerSuffix;
    }

    /**
     * @return string
     */
    public function getActionSuffix()
    {
        return $this->_actionSuffix;
    }

    /**
     * @param string $actionSuffix
     */
    public function setActionSuffix($actionSuffix)
    {
        $this->_actionSuffix = $actionSuffix;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * @param mixed $params
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getParam($name)
    {
        return isset($this->_params[$name]) ? $this->_params[$name] : null;
    }

    /**
     * @return mixed
     */
    public function getReturnValue()
    {
        return $this->_returnValue;
    }

    /**
     * @param mixed $returnValue
     */
    public function setReturnValue($returnValue)
    {
        $this->_returnValue = $returnValue;
    }

    /**
     * @return mixed
     */
    public function getDefaultNamespace()
    {
        return $this->_defaultNamespace;
    }

}