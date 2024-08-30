<?php

namespace app\controllers;

use app\database\models\User;
use core\auth\AuthManager;
use core\library\Response;

class HomeController
{
  public function index(AuthManager $auth): Response
  {
    dump($auth->user());
    $users = User::where('id', '>', 10)->paginate(19);
    // dd($users);
    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre',
      'users' => $users
    ]);
  }
}
