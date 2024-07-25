<?php

use core\library\App;
use core\library\Redirect;
use core\templates\Plates;

$app = App::create()
  ->withEnvironmentVariables()
  ->withTemplateEngine(Plates::class)
  // ->withMiddlewares([
  //   GlobalMiddleware::class
  // ])
  ->withErrorPage()
  ->withDependencyInjectionContainer()
  ->withServiceContainer();
