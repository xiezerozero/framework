<?php
/**
 * Filter.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library;


/**
 * Class Filter
 *
 * @package Library
 */
class Filter
{

    private $_filters = [];

    /**
     * 加入默认的过滤器
     */
    function __construct()
    {
        $this->_filters['url'] = function ($value) {
            return filter_var($value, FILTER_VALIDATE_URL);
        };
        $this->_filters['ip'] = function ($value) {
            return filter_var($value, FILTER_VALIDATE_IP);
        };
        $this->_filters['email'] = function ($value) {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        };
        $this->_filters['int'] = function ($value) {
            return filter_var($value, FILTER_VALIDATE_INT);
        };
    }


    /**
     * @param $value
     * @param $filters
     *
     * @return mixed
     * @throws \Exception
     */
    public function validate($value, $filters)
    {
        if (is_string($filters)) {
            return $this->validateItem($value, $filters);
        } elseif (is_array($filters)) {
            $return = $value;
            foreach ($filters as $filter) {
                $return = $this->validateItem($return, $filter);
            }
            return $return;
        }
    }

    /**
     * @param $value
     * @param $filter
     *
     * @return mixed
     * @throws \Exception
     */
    private function validateItem($value, $filter)
    {
        if (!isset($this->_filters[$filter])) {
            throw new \Exception("$filter is not supported");
        }
        $handler = $this->_filters[$filter];
        return call_user_func($handler, $value);
    }

    /**
     * @param string   $name
     * @param callable $handler
     */
    public function add($name, $handler)
    {
        $this->_filters[$name] = $handler;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->_filters;
    }


} 