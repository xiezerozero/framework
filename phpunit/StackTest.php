<?php
/**
 * StackTest.php
 *
 * PhpStorm
 *
 * @author: xielin
 */
namespace Phpunit;

/**
 * Class StackTest
 * @package Phpunit
 */
class StackTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Right
     */
    public function testException()
    {
        throw new \InvalidArgumentException('Right');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionCode 10
     */
    public function testExceptionCode()
    {
        throw new \InvalidArgumentException('',10);
    }


}
