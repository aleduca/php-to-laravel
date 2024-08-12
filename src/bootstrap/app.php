<?php

use core\library\App;
use core\middlewares\GlobalMiddleware;
use core\templates\Plates;

$app = App::create()
  ->withSession()
  ->withEnvironmentVariables()
  ->withTemplateEngine(Plates::class)
  // ->withMiddlewares([
  //   GlobalMiddleware::class
  // ])
  ->withErrorPage()
  ->withDependencyInjectionContainer()
  ->withServiceContainer();
