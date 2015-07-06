<?php
/**
 * Collection.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Tool;


/**
 * Class Collection
 *
 * @package Library\Tool
 */
class Collection
{

    private $_items = [];

    /**
     * 添加元素
     *
     * @param      $value
     * @param null $key
     */
    public function addItem($value,  $key = null)
    {
        if ($key === null) {
            $this->_items[] = $value;
        } else {
            if (isset($this->_items[$key])) {
                throw new \InvalidArgumentException("Key $key already in use");
            } else {
                $this->_items[$key] = $value;
            }
        }
    }

    /**
     * @param $key
     */
    public function deleteItem($key)
    {
        if (!$this->keyExists($key)) {
            throw new \InvalidArgumentException("Key $key is not used");
        } else {
            unset($this->_items[$key]);
        }
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getItem($key)
    {
        if (!$this->keyExists($key)) {
            throw new \InvalidArgumentException("Key $key is not used");
        } else {
            return $this->_items[$key];
        }
    }

    /**
     * @return array
     */
    public function keys()
    {
        return array_keys($this->_items);
    }

    /**
     * @return int
     */
    public function length()
    {
        return count($this->_items);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function keyExists($key)
    {
        return isset($this->_items[$key]);
    }


} 