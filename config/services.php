<?php

/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */

/**
 * Registering a router
 */
$di['router'] = function () {

    $router = new Router();

    $router->setDefaultModule("frontend");
    $router->setDefaultNamespace("Myphalcon\\Frontend\\Controllers");
	$router->addGet('/test',array(
		'controller'=>'Index',
		'action'=>'test',
	));

    return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

/**
 *  Whoops Exception handler
 */
new Whoops\Provider\Phalcon\WhoopsServiceProvider($di);

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
	'Snowair\Debugbar' => __DIR__ . '/../debugbar/',
));
$loader->register();
$provider = new Snowair\Debugbar\ServiceProvider();
$provider->register();
$di['debugbar']->enable();
$provider->boot();