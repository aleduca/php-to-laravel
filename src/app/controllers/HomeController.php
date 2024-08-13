<?php

namespace app\controllers;

use app\database\models\User;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    // users
    // $user = new User;
    // $user->firstName = 'Alexandre';
    // $user->lastName = 'Cardoso';
    // $user->email = 'xandecar@hotmail.com';
    // $user->password = password_hash('123456', PASSWORD_DEFAULT);
    // $user->save();

    User::create([
      'firstName' => 'Alexandre',
      'lastName' => 'Cardoso',
      'email' => 'xandecar@hotmail.com',
      'password' => password_hash('123456', PASSWORD_DEFAULT)
    ]);

    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre'
    ]);
  }
}
