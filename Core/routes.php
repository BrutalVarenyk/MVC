<?php

$router->add('users', ['controller' => 'UserController', 'action' => 'index']);
$router->add('users/{id:\d+}/show', ['controller' => 'UserController', 'action' => 'show']);
$router->add('auth/registration', ['controller' => 'UserController', 'action' => 'register']);
$router->add('auth/login', ['controller' => 'UserController', 'action' => 'login']);
$router->add('auth/logout', ['controller' => 'UserController', 'action' => 'logout']);


$router->add('', ['controller' => 'ArticlesController', 'action' => 'index']); // ArticlesController with method index()
$router->add('articles/{id:\d+}', ['controller' => 'ArticlesController', 'action' => 'show']); // ArticlesController with method show($id);
$router->add('articles/create', ['controller' => 'ArticlesController', 'action' => 'create']);
$router->add('articles/{id:\d+}/edit', ['controller' => 'ArticlesController', 'action' => 'edit']);
$router->add('articles/{id:\d+}/remove', ['controller' => 'ArticlesController', 'action' => 'remove']);