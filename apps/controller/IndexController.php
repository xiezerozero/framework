<?php
/**
 * IndexController.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

namespace Api\Controller;


use Library\Mvc\Controller;

/**
 * Class IndexController
 * @package Controller
 *
 */
class IndexController extends Controller
{


    public function indexAction()
    {
        $this->_di->get('logger',['t.txt'])->debug(123 . PHP_EOL);
//        $this->dispatcher->setController('index');
//        $this->dispatcher->setAction('test');
//        $this->dispatcher->setParams([
//            'name' => 'username',
//        ]);
//        $this->dispatcher->dispatch();
        $this->template->assign([
            'a' => 'hello world'
        ]);
        $this->template->display('index/index');
    }

    public function testAction()
    {
        echo 'test haha';
    }

} 