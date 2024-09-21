<?php

namespace app\controllers;

use app\database\models\Post;
use app\database\models\User;
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
