<?php
/**
 * TestBook.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Test\Collection;


/**
 * Class TestBook
 *
 * @package Test\Collection
 */
class TestBook
{

    private $_bookName;

    private $_bookNum;

    private $_bookPrice;

    /**
     * @param $_bookName
     * @param $_bookNum
     * @param $_bookPrice
     */
    function __construct($_bookName, $_bookNum, $_bookPrice)
    {
        $this->_bookName = $_bookName;
        $this->_bookNum = $_bookNum;
        $this->_bookPrice = $_bookPrice;
    }


} 