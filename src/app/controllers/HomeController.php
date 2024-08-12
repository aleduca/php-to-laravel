<?php

namespace app\controllers;

use app\database\models\User;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $user = User::where('id', '>', 5);

    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre'
    ]);
  }
}
