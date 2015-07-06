<?php
/**
 * DiContainer.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\DI;


use Library\Filter;

/**
 * Class DiContainer
 *
 * @package Library\DI
 *
 * $di = new \Library\DiContainer();
 * $di->set('test', '\\Library\\Test');
 * $di->set('test', function () {
 *      return new \Library\Test();
 * });
 * $di->set('test', $testObject);
 *
 *
 */
class DiContainer implements DiInterface
{
    /** @var array 保存注入的类的定义,不保存实例化后的对象 */
    static $_servicesDefine = [];

    /** @var array 保存实例化的对象 */
    static $_services = [];

    /**
     * inject the default services
     */
    public function __construct()
    {
        /**
         * 默认注入的服务
         * $name => $definition
         */
        $defaultInjection = [
            'filter'     => function () {
                return new Filter();
            },
            'router'     => "\\Library\\Mvc\\Router",
            'template'   => "\\Library\\Mvc\\Template",
            'request'    => "\\Library\\Request",
            'dispatcher' => "\\Library\\Dispatcher",
			'compiler'	 => "\\Library\\Mvc\\TemplateImpl\\CompileClass",
        ];

        foreach ($defaultInjection as $name => $definition) {
            $this->set($name, $definition);
        }
    }

    /**
     * 类名和匿名函数先放入serviceDefine中,要使用在实例化放入services中
     *
     * @param string                 $name
     * @param \Closure|string|object $definition
     * @param bool                   $shared
     */
    public function set($name, $definition, $shared = null)
    {
        if (is_string($definition)) {
            self::$_servicesDefine[$name] = $definition;
        } elseif ($definition instanceof \Closure) {
            self::$_servicesDefine[$name] = $definition;
        } elseif (is_object($definition)) {     //直接注入对象,类已经加载了,不需要做自动加载,同时保存到_services中
            self::$_servicesDefine[$name] = $definition;
            self::$_services[$name] = $definition;
        }
    }

    /**
     * check if the container has the service named $name
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset(self::$_servicesDefine[$name]);
    }

    /**
     * remove the service out of container
     *
     * @param $name
     */
    public function remove($name)
    {
        unset(self::$_servicesDefine[$name]);
        unset(self::$_services[$name]);
    }

    /**
     * @param      $name
     * @param null $parameter
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($name, $parameter = null)
    {
        if (isset(self::$_services[$name])) {   //如果已经实例化,则返回实例化的对象
            return self::$_services[$name];
        }
        if (!isset(self::$_servicesDefine[$name])) {
            throw new \Exception("can not find the instance of {$name}");
        }
        $definition = self::$_servicesDefine[$name];
        if (is_string($definition)) {
            if (class_exists($definition, true)) {
                self::$_services[$name] = new $definition($parameter);
            } else {
                throw new \Exception("can not find class {$definition}");
            }
        } elseif ($definition instanceof \Closure) {
            self::$_services[$name] = call_user_func_array($definition, ($parameter === null ? [] : $parameter));
        } else {
            throw new \Exception("service must be a string,an object or an instance of Closure");
        }
        if (self::$_services[$name] instanceof InjectionAwareInterface) {
            //实现该接口,将di注入
            self::$_services[$name]->setDI($this);
        }
        return self::$_services[$name];
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return self::$_services;
    }

}