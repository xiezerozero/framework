<?php
/**
 * Verification.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Tool;


/**
 * PHP表单字段验证类
 *
 * Class Verification
 *
 * @package Library\Tool
 */
class Verification
{

    /**
     * 验证字符串长度是否在指定的范围内
     *
     * @param string $str
     * @param int    $min
     * @param int    $max
     *
     * @return bool
     */
    public static function fun_length($str, $min, $max)
    {
        $length = strlen($str);
        return ($length > $min && $length < $max) ? true : false;
    }

    /**
     * 验证是否为指定长度的字母/数字组合
     *
     * @param $num1
     * @param $num2
     * @param $str
     *
     * @return bool
     */
    function fun_alphanum($num1, $num2, $str)
    {
        return (preg_match("/^[a-za-z0-9]{" . $num1 . "," . $num2 . "}$/", $str)) ? true : false;
    }

    /**
     * 验证是否为指定长度数字
     *
     * @param $num1
     * @param $num2
     * @param $str
     *
     * @return bool
     */
    function fun_digit($num1, $num2, $str)
    {
        return (preg_match("/^[0-9]{" . $num1 . "," . $num2 . "}$/i", $str)) ? true : false;
    }

    /**
     * 验证是否为指定长度汉字
     *
     * @param $num1
     * @param $num2
     * @param $str
     *
     * @return bool
     */
    function fun_font($num1, $num2, $str)
    {
        return (preg_match("/^([\x81-\xfe][\x40-\xfe]){" . $num1 . "," . $num2 . "}$/", $str)) ? true : false;
    }

    /**
     * 验证邮件地址
     *
     * @param $str
     *
     * @return bool
     */
    function fun_email($str)
    {
        return (preg_match('/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$/', $str)) ? true : false;
    }

    /**
     * 验证电话号码
     *
     * @param $str
     *
     * @return bool
     */
    function fun_phone($str)
    {
        return (preg_match("/^(((d{3}))|(d{3}-))?((0d{2,3})|0d{2,3}-)?[1-9]d{6,7}$/", $str)) ? true : false;
    }

    /**
     * 验证手机号码
     *
     * @param $str
     *
     * @return bool
     */
    function fun_mobile($str)
    {
        return (preg_match("/^1[358][0123456789]\d{8}$/", $str)) ? true : false;
    }

    /**
     * 验证邮编
     *
     * @param $str
     *
     * @return bool
     */
    function fun_zip($str)
    {
        return (preg_match("/^[1-9]d{5}$/", $str)) ? true : false;
    }


}