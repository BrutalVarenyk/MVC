<?php

/**
 * $router->add('', ['controller' => 'Home', 'action' => 'index']); // HomeController with method index()
 * $router->add('posts/index', ['controller' => 'ArticlesController', 'action' => 'index']); // ArticlesController with method index()
 * $router->add('posts/{id:\d}', ['controller' => 'ArticlesController', 'action' => 'show']); // ArticlesController with method show($id);
 */

//$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('users', ['controller' => 'UserController', 'action' => 'index']);
$router->add('users/{id:\d+}/show', ['controller' => 'UserController', 'action' => 'show']);
$router->add('auth/registration', ['controller' => 'UserController', 'action' => 'create']);

$router->add('', ['controller' => 'ArticlesController', 'action' => 'index']); // ArticlesController with method index()
$router->add('articles/{id:\d+}', ['controller' => 'ArticlesController', 'action' => 'show']); // ArticlesController with method show($id);
