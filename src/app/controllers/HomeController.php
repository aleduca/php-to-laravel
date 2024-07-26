<?php

namespace app\controllers;

use core\library\Redirect;
use core\library\Request;
use core\library\Response;
use core\library\Session;

class HomeController
{
  public function index(): Response
  {
    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre'
    ]);
  }
}
