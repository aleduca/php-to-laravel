<?php

use core\library\App;

$app = App::create()
  ->withEnvironmentVariables()
  ->withErrorPage()
  ->withContainer();
