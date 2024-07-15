<?php

use core\library\App;
use core\templates\Plates;

$app = App::create()
  ->withEnvironmentVariables()
  ->withTemplateEngine(Plates::class)
  ->withErrorPage()
  ->withContainer();
