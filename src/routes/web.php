<?php

use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\ProductController;
use core\library\Router;

try {
  $router = new Router;
  $router->add('GET', '/', [HomeController::class, 'index']);
  $router->add('GET', '/product/([a-z\-]+)', [ProductController::class, 'index']);
  $router->add('GET', '/product/([a-z\-]+)/category/([a-z0-9]+)', [ProductController::class, 'index']);
  $router->add('GET', '/login', [LoginController::class, 'index']);
  $router->add('POST', '/login', [LoginController::class, 'store']);
  $router->execute();
} catch (\Throwable $th) {
  //throw $th;
}
