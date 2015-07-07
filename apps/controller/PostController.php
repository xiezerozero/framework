<?php
/**
 * PostController.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Api\Controller;

use Library\Mvc\Controller;

/**
 * Class PostController
 *
 * @package Controller
 */
class PostController extends Controller
{

    public function addAction()
    {
        echo "PostController::addAction()";
		echo 'this is the dev branch';
		exit;
    }

	public function devAction()
	{
		echo 'devAction';
	}

} 