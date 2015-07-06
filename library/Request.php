<?php
/**
 * Request.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;


use Library\DI\DiContainer;
use Library\DI\InjectionAwareInterface;

/**
 * Class Request
 *
 * @package Library
 */
class Request implements InjectionAwareInterface
{
    /** @var  Filter */
    protected $_filter;

    protected $_di;

    /**
     * @param null $name
     * @param null $filter
     * @param null $defaultValue
     *
     * @return mixed|null
     */
    public function get($name = null, $filter = null, $defaultValue = null)
    {
        $value = null;
        isset($_GET[$name]) && $value = $_GET[$name];
        ($value === null && isset($_POST[$name])) && $value = $_POST[$name];
        $value !== null && $value = $this->_filter->validate($value, $filter);
        return ($value === null || $value === false) ? $defaultValue : $value;
    }

    /**
     * @param null $name
     * @param null $filter
     * @param null $defaultValue
     *
     * @return mixed|null
     */
    public function getQuery($name = null, $filter = null, $defaultValue = null)
    {
        $value = null;
        isset($_GET[$name]) && $value = $_GET[$name];
        $value !== null && $value = $this->_filter->validate($value, $filter);
        return ($value === null || $value === false) ? $defaultValue : $value;
    }

    /**
     * @param null $name
     * @param null $filter
     * @param null $defaultValue
     *
     * @return mixed|null
     */
    public function getPost($name = null, $filter = null, $defaultValue = null)
    {
        $value = null;
        isset($_POST[$name]) && $value = $_POST[$name];
        $value !== null && $value = $this->_filter->validate($value, $filter);
        return ($value === null || $value === false) ? $defaultValue : $value;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getServer($name)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : '';
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($_GET[$name]) || isset($_POST[$name]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasQuery($name)
    {
        return isset($_GET[$name]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasPost($name)
    {
        return isset($_POST[$name]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasServer($name)
    {
        return isset($_SERVER[$name]);
    }

    /**
     * @param $header
     *
     * @return string
     */
    public function getHeader($header)
    {
        $headers = $this->getHeaders();
        return isset($headers[$header]) ? $headers[$header] : '';
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                //把DEVICE_NAME/device_name 转换成device-name
                $headers[str_replace(' ', '-', strtolower(str_replace('_', '-', substr($name, 5))))] = $value;
            }
        }
        return $headers;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        if (isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'],
                'https') === 0
        ) {
            return 'https';
        }
        return 'http';
    }


    /**
     * @return string
     */
    public function getServerAddress()
    {
        return isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
    }

    public function getServerName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public function getServerPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    /**
     * @return string
     */
    public function getClientHost()
    {
        return isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : '';
    }

    /**
     * @return string
     */
    public function getClientAddress()
    {
        static $ip = null;
        if ($ip !== null) {
            return $ip;
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
        return $ip;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    }

    /**
     * @return string
     */
    public function getURI()
    {
        return isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    /**
     * @return bool
     */
    public function getIsPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
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
     * sets the dependency injector
     *
     * @param DiContainer $dependencyInjector
     */
    public function setDI($dependencyInjector)
    {
        $this->_di = $dependencyInjector;
        //注入request对象需要的服务,这里只需要filter,只设置filter,可以设置更多
        $this->_filter = $this->_di->get('filter');
    }
}