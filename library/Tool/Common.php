<?php
/**
 * Common.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Tool;


/**
 * Class Common
 *
 * @package Library\Tool
 */
class Common
{

    /**
     * 从字符串或者数组中找到所有的数字
     *
     * @param $stringOrArray
     *
     * @throws \Exception
     */
    public static function findNum($stringOrArray)
    {
        if (is_string($stringOrArray)) {
            if (empty($stringOrArray)) {
                return '';
            }
            $numbers = array_filter(str_split($stringOrArray), function ($v) {
                return is_numeric($v);
            });
            return implode('', $numbers);
        } elseif (!is_array($stringOrArray)) {
            if (empty($stringOrArray)) {
                return '';
            }
            $numbers = array_filter($stringOrArray, function ($v) {
                return is_numeric($v);
            });
            return implode('', $numbers);
        } else {
            throw new \Exception('parameter type ' . gettype($stringOrArray) . 'is not acceptable');
        }
    }

	/**
	 * @param $string
	 * @param $startWith
	 *
	 * @return bool
	 */
	public static function startWith($string, $startWith)
	{
		if (!is_string($string) || !is_string($startWith)) {
			trigger_error('parameter $string and $startWith all must be string!', E_USER_ERROR);
		}

		return strpos($string, $startWith) === 0;
	}

	/**
	 * @param $string
	 * @param $endWith
	 *
	 * @return bool
	 */
	public static function endWith($string, $endWith)
	{
		if (!is_string($string) || !is_string($endWith)) {
			trigger_error('parameter $string and $endWith all must be string!', E_USER_ERROR);
		}
		//反向指定长度字符串与$endWith是否相同,判断是否endWith
		return substr($string, -strlen($endWith)) === $endWith;
	}

	/**
	 * 获取文件名后缀
	 *
	 * @param $fileName
	 *
	 * @return mixed
	 */
	public static function getFileExtension($fileName)
	{
		return pathinfo($fileName, PATHINFO_EXTENSION);
	}

	/**
	 * 对一个多维数组,递归处理,生成一维数组,根据条件确定是否保存键值
	 *
	 * @param array $array
	 * @param bool  $preserve_keys
	 *
	 * @return array
	 */
	public static function array_flatten(array $array, $preserve_keys = true)
	{
		$results = [];

		array_walk_recursive($array, function ($value, $key) use (&$results, $preserve_keys) {
			if ($preserve_keys) {
				$results[$key] = $value;
			} else {
				$results[] = $value;
			}
		});
		return $results;
	}


} 