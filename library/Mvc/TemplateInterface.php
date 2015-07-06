<?php
/**
 * TemplateInterfac.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Mvc;


/**
 * Interface TemplateInterface
 *
 * @package library\Mvc
 */
interface TemplateInterface
{

	/**
	 * @param $controller
	 * @param $action
	 */
	public function init($controller, $action);

	/**
	 * @return mixed
	 */
	public function getController();

	/**
	 * @return mixed
	 */
	public function getAction();

	/**
	 * @param      $value
	 * @param null $key
	 *
	 * @return mixed
	 */
	public function assign($value, $key = null);


	/**
	 * @param $filePathAndName
	 *
	 * @return mixed
	 */
	public function display($filePathAndName);


}