<?php

use core\library\App;
use core\middlewares\GlobalMiddleware;
use core\templates\Plates;

$app = App::create()
  ->withEnvironmentVariables()
  ->withTemplateEngine(Plates::class)
  // ->withMiddlewares([
  //   GlobalMiddleware::class
  // ])
  ->withErrorPage()
  ->withContainer();
