<?php

/**
 * Template.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

class Template
{
	private $arrayConfig = [
		'suffix'       => '.html',    //模板文件的后缀
		'templateDir'  => '../template/',    //模板所在的文件夹
		'compiledDir'  => './cache/',    //编译后存放的文件夹
		'cache_html'   => false,    //是否需要编译成静态HTML文件
		'suffix_cache' => '.php',    //编译文件的后缀
		'cache_time'   => 7200,    //多长时间更新,单位秒
		'debug' => false,
	];

	public $file;

	static private $instance = null;

	private $values = [];

	/** @var  CompileClass */
	private $compiledTool;

	/**
	 *
	 */
	public function __construct($compiler)
	{
		include "CompileClass.php";
		$this->compiledTool = new CompileClass();
	}


	/**
	 * @param      $key
	 * @param null $value
	 */
	public function setConfig($key, $value = null)
	{
		if (is_array($key)) {
			$this->arrayConfig = $key + $this->arrayConfig;
		} else {
			$this->arrayConfig[$key] = $value;
		}
	}

	/**
	 * @param null $key
	 *
	 * @return array|null
	 */
	public function getConfig($key = null)
	{
		if ($key !== null) {
			return isset($this->arrayConfig[$key]) ? $this->arrayConfig[$key] : null;
		} else {
			return $this->arrayConfig;
		}
	}

	/**
	 * @return string
	 */
	public function filePath()
	{
		return $this->arrayConfig['templateDir'] . $this->file . $this->arrayConfig['suffix'];
	}

	/**
	 * @param      $value
	 * @param null $key
	 */
	public function assign($value, $key = null)
	{
		if ($key === null) {	//批量
			if (!is_array($value)) {	//批量如果不是数组,说明传递的参数不合理
				trigger_error("illegal arguments passed", E_USER_ERROR);
			}
			foreach ($value as $k => $v) {
				$this->values[$k] = $v;
			}
		} else {	//单个
			$this->values[$key] = $value;
		}
	}

	/**
	 * @param $filePath
	 *
	 * @throws Exception
	 */
	public function display($filePath)
	{
		$this->file = $filePath;
		$this->compiledTool->setValues($this->values);
		if (!is_file($this->filePath())) {
			throw new \Exception("template $filePath does not exist");
		}
		$compiledFile = $this->arrayConfig['compiledDir'] . md5($filePath) . $this->arrayConfig['suffix_cache'];
		if ($this->arrayConfig['debug'] || !is_file($compiledFile) || filemtime($compiledFile) < filemtime($this->filePath())) {
			//调试模式,每次都编译;非调试模式,根据文件的修改时间确定是否重新编译
			$this->compiledTool->compile($this->filePath(), $compiledFile);
		} //非调试模式,已编译并且修改时间符合要求直接读取编译的文件
		ob_start();
		extract($this->values);
		include $compiledFile;
		$content = ob_get_contents();
		ob_end_clean();
		echo $content;
	}

}


//$t = Template::getInstance();
//var_dump($t->getConfig());
/*ob_start();
include 'test.html';
$content = ob_get_contents();
ob_flush();
ob_end_clean();*/
//echo $content;
$t = Template::getInstance();
$t->assign('test-data', 'data');
$t->assign('test-data', 'test');
$t->assign(['name' => 'name'], 'name');
$t->assign([['name' => 'name1'], ['name' => 'name2']], 'array');
$t->display('member');
