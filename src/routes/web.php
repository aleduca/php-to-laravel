<?php

use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\ProductController;
use app\middlewares\AuthMiddleware;
use app\middlewares\GuestMiddleware;
use app\middlewares\TesteMiddleware;
use core\library\Router;

$router = $app->container->get(Router::class);
$router->add('GET', '/', [HomeController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->add('GET', '/product/([a-z\-]+)', [ProductController::class, 'show'])->middleware([AuthMiddleware::class, TesteMiddleware::class]);
$router->add('GET', '/product/([a-z\-]+)/category/([a-z0-9]+)', [ProductController::class, 'show']);
$router->add('GET', '/login', [LoginController::class, 'index'])->middleware([GuestMiddleware::class]);
$router->add('POST', '/login', [LoginController::class, 'store']);
$router->execute();
