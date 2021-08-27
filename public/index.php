<?php
ini_set("display_errors",1);
ini_set("display_startup_errors", 1);
error_reporting(-1);

require_once "../vendor/autoload.php";

use Core\Router;

// 1 - RouterInstance
$router = new Router();

// 2 - include routes
include "../Core/routes.php";

// 3 - router dispatch

try{
    $path = trim($_SERVER["REQUEST_URI"], "/");
    $router->dispatch($path);
} catch (Exception $e) {
    dd($e->getMessage());
}
