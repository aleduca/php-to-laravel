<?php

namespace core\controllers;

class ErrorController
{
  public function notFound()
  {
    view('errors/404', [
      'title' => 'Page Not Found'
    ], VIEW_PATH_CORE);
  }
}
