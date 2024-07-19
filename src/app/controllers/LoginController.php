<?php

namespace app\controllers;

use core\library\Request;

class LoginController
{
  public function index()
  {
    dump('teste');
    return view('login', [
      'title' => 'Login',
    ]);
  }

  public function store(Request $request)
  {
    dd($request);
  }
}
