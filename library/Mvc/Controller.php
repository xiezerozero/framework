<?php
/**
 * Controller.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Library\Mvc;

use Library\DI\Injectable;

/**
 * Class Controller
 *
 * @package Library\Mvc
 */
abstract class Controller extends Injectable
{


    /**
     *
     */
    public function beforeAction()
    {
    }

    /**
     *
     */
    public function afterAction()
    {
    }


}