<?php
/**
 * DiInterface.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\DI;


/**
 * Interface DiInterface
 *
 * @package Library\DI
 */
interface DiInterface
{

    /**
     * @param      $name
     * @param      $value
     *
     * @param null $shared
     *
     * @return mixed
     */
    public function set($name, $value, $shared = null);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function has($name);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function remove($name);

    /**
     * @param      $name
     * @param null $parameter
     *
     * @return mixed
     */
    public function get($name, $parameter = null);

} 