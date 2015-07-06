<?php
/**
 * InjectionAwareInterface.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\DI;


/**
 * Interface InjectionAwareInterface
 *
 * @package Library\DI
 */
interface InjectionAwareInterface
{

    /**
     * sets the dependency injector
     *
     * @param DiContainer $dependencyInjector
     */
    public function setDI($dependencyInjector);


    /**
     * Returns the internal dependency injector
     *
     * @return DiContainer
     */
    public function getDI();

} 