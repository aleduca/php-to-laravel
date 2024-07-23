<?php

namespace app\controllers;

use app\rules\Cpf;
use core\library\Request;

class LoginController
{
  public function index()
  {
    return view('login', [
      'title' => 'Login',
    ]);
  }

  public function store(Request $request)
  {
    $validated  = $request->validate([
      'email' => 'max:10',
      'password' => 'required|' . Cpf::class,
    ]);

    if ($validated->hasErrors()) {
      dd($validated->errors());
      // return back()->with($validated->errors);
    }

    dd($validated->data);

    die();
  }
}
