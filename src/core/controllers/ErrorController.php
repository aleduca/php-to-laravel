<?php

namespace core\controllers;

use core\library\Response;

class ErrorController
{
  public function notFound(): Response
  {
    return view('errors/404', [
      'title' => 'Page Not Found'
    ], VIEW_PATH_CORE);
  }
}
