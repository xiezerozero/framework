<?php
/**
 * Injectable.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\DI;


/**
 * Class Injectable
 *
 * @package Library\DI
 *
 * @property \Library\Mvc\Router   $router     路由
 * @property \Library\Request      $request    请求
 * @property \Library\Filter       $filter     过滤器
 * @property \Library\Mvc\TemplateImpl\Template $template   模板
 * @property \Library\Dispatcher   $dispatcher 分发器
 */
abstract class Injectable
{

    /** @var DiContainer $di */
    protected $_di;

    /**
     * @param DiContainer $di
     */
    function __construct(DiContainer $di)
    {
        $this->_di = $di;
    }

    /**
     * @param  $name
     *
     * @throws \Exception
     */
    public function __get($name)
    {
        if (property_exists($this, $name) && $this->$name !== null) { //处理自定义的属性或者获取已经注入的属性服务
            return $this->$name;
        }
        if ($this->_di->has($name)) {   //不然就去获取di中的属性
            $this->$name = $this->_di->get($name);
            return $this->$name;
        }
        throw new \Exception("property $name is not defined in " . __CLASS__);
    }


}