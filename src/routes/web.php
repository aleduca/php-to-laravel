<?php

use app\controllers\CommentController;
use app\controllers\HomeController;
use app\controllers\PostController;
use core\library\Router;

$router = $app->container->get(Router::class);
$router->add('GET', '/', [HomeController::class, 'index']);
$router->add('GET', '/post/([a-z\-]+)', [PostController::class, 'show']);
$router->add('POST', '/comment', [CommentController::class, 'store']);
$router->execute();
