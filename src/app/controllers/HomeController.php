<?php

namespace app\controllers;

use app\database\models\User;
use core\library\Redirect;
use core\library\Request;
use core\library\Response;
use core\library\Session;

class HomeController
{
  public function index(): Response
  {
    $user = new User;
    $user = $user->where('id', '>', 5);
    dd($user);
    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre'
    ]);
  }
}
