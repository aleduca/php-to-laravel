<?php

namespace app\controllers;

use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    return view('home', [
      'title' => 'Home Page',
    ]);
  }
}
