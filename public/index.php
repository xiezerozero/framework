<?php
/**
 * index.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

use Library\Application;
use Library\DI\DiContainer;
use Library\Loader;
use Library\Logger;
const PROJECT_DIR = '..';
include dirname(__FILE__) . '/Loader.php';
$loader = new Loader();

/** 注册命名空间目录 */
$loader->registerNamespace([
    'Library' => PROJECT_DIR . '/library',
    'Api\Controller' => PROJECT_DIR . '/apps/controller',
]);

try {
    $config = require_once PROJECT_DIR . '/public/config.php';
    $di = new DiContainer();
    $di->set('logger', function ($logName = 'app.txt') use ($config) {
        return new Logger($config['log']['dir'] . $logName);
    });
	//重新设置view组件
	$di->set('template', function () use ($di) {
		$compiler = $di->get('compiler');
		$template = new \Library\Mvc\TemplateImpl\Template($compiler);
		$template->setConfig([
			'templateDir' => PROJECT_DIR . '/apps/view/',
			'compiledDir' => PROJECT_DIR . '/apps/cache/',
			'debug' => true,
		]);
		return $template;
	});
    $di->set('dispatcher', function () {
        $dispatcher = new \Library\Dispatcher();
        $dispatcher->setDefaultNamespace('Api\Controller');
        return $dispatcher;
    });
    // todo here : inject services
    $application = new Application($di);
    $application->handle();
} catch (Exception $e) {
    echo "<pre>";
    echo $e;
} finally {
}

