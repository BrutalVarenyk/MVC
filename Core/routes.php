<?php

/**
 * $router->add('', ['controller' => 'Home', 'action' => 'index']); // HomeController with method index()
 * $router->add('posts/index', ['controller' => 'Posts', 'action' => 'index']); // PostsController with method index()
 * $router->add('posts/{id:\d}', ['controller' => 'Posts', 'action' => 'show']); // PostsController with method show($id);
 */
//$router->add("", ["controller" =>  "Home", "action" => "index"]);
$router->add('posts/{id:\d+}/show', ['controller' => 'Posts', 'action' => 'show']);