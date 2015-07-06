<?php
/**
 * TestUser.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Test\Collection;

require '../../library/Tool/Collection.php';
use Library\Tool\Collection;


/**
 * Class TestUser
 *
 * @package Test\Collection
 */
class TestUser
{

    /** @var  Collection 用于保存TestBook的集合 */
    private $_bookCollection;

    private $_name;

    private $_age;

    /**
     * @param $_age
     * @param $_name
     */
    function __construct($_age, $_name)
    {
        $this->_age = $_age;
        $this->_name = $_name;
    }

    /**
     * @return Collection
     */
    public function getBookCollection()
    {
        if ($this->_bookCollection === null) {
            $this->_bookCollection = new Collection();
        }
        return $this->_bookCollection;
    }

    /**
     * @param Collection $bookCollection
     */
    public function setBookCollection($bookCollection)
    {
        $this->_bookCollection = $bookCollection;
    }


} 