<?php
/**
 * Template.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Mvc\TemplateImpl;

use Library\Mvc\TemplateInterface;


/**
 * Class Template
 *
 * @package Library\Mvc
 */
class Template implements TemplateInterface
{

    private $_controller;

    private $_action;

    /** @var  string 模板 */
    private $_layout;

    /** @var array 变量集合 */
    private $_params;

    private $_templateExt = self::TEMPLATE_EXT;

    /** @var int 渲染级别 */
    private $_level = self::LEVEL_LAYOUT;

    /** @var bool 是否开启视图渲染 */
    private $_enable = true;

    /** @var string 默认layout */
    const DEFAULT_LAYOUT = 'main';

    /** @var int 不渲染视图 */
    const LEVEL_NO_RENDER = 0;

    /** @var int 只渲染action的视图 */
    const LEVEL_ACTION_VIEW = 1;

    /** @var int action和layout视图一起渲染 */
    const LEVEL_LAYOUT = 2;

    /** @var string 模板文件后缀名 */
    const TEMPLATE_EXT = '.htpl';

    /** @var string layout 文件中用于替换action视图的标示内容 */
    private $_content = '[content]';

    /**
     * @param $controller
     * @param $action
     */
    public function init($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_layout = self::DEFAULT_LAYOUT;
    }

    /**
     * 开启视图
     */
    public function enable()
    {
        $this->_enable = true;
    }

    /**
     * 禁用视图
     */
    public function disable()
    {
        $this->_enable = false;
    }

    /**
     * 视图是否禁用
     *
     * @return bool
     */
    public function isDisabled()
    {
        return $this->_enable === false;
    }

    /**
     * 渲染指定的视图
     *
     * @param $filePathAndName
     */
    public function display($filePathAndName)
    {
        if ($this->_enable) {   //开启视图渲染
            $out = '';
            if (in_array($this->_level, [self::LEVEL_LAYOUT, self::LEVEL_ACTION_VIEW])) { //渲染action 或者渲染layout
                $actionContent = $this->getTemplateContent(PROJECT_DIR . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $filePathAndName . $this->_templateExt,
                    $this->_params);
                if ($actionContent !== false) { //找到文件
                    $out = $actionContent;
                }
            }
            if ($this->_level == self::LEVEL_LAYOUT) {  //如果是渲染模板
                $layoutContent = $this->getLayoutContent();
                if ($layoutContent !== false) {     //找到文件
                    $out = str_replace($this->_content, $out, $layoutContent);
                }
            }
            echo $out;
        }
    }

    /**
     * 获取layout的视图内容
     *
     * @return null|string
     */
    private function getLayoutContent()
    {
        return $this->getTemplateContent(PROJECT_DIR . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . $this->_layout . $this->_templateExt,
            $this->_params);
    }

    /**
     * 设置渲染级别
     *
     * @param int $level
     */
    public function setRenderLevel($level)
    {
        $this->_level = $level;
    }

    /**
     * 获取模板文件的内容
     *
     * @param string $file   文件路径
     * @param array  $params 参数
     *
     * @return bool|string
     */
    private function getTemplateContent($file, $params = [])
    {
        if (!file_exists($file)) {
            return false;
        }
        if (!empty($params)) {
            extract($params);   //将参数设置到模板的作用域中
        }
        ob_clean();
        ob_start();
        include $file;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @param mixed $layout
     */
    public function setLayout($layout)
    {
        if (!empty($layout)) {
            $this->_layout = $layout;
        }
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param mixed $params
     */
    public function assign($value, $key = null)
    {
        $this->_params = $value;
    }

    /**
     * @return string
     */
    public function getTemplateExt()
    {
        return $this->_templateExt;
    }

    /**
     * @param string $templateExt
     */
    public function setTemplateExt($templateExt)
    {
        $this->_templateExt = $templateExt;
    }

	/**
	 * @return mixed
	 */
	public function getController()
	{
		return $this->_controller;
	}

	/**
	 * @return mixed
	 */
	public function getAction()
	{
		return $this->_action;
	}


}
