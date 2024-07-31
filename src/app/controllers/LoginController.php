<?php

namespace app\controllers;

use app\rules\Cpf;
use core\library\Redirect;
use core\library\Request;

class LoginController
{
  public function index(Request $request)
  {
    return view('login', [
      'title' => 'Login',
    ]);
  }

  public function store(Request $request)
  {
    $validated  = $request->validate([
      'email' => 'required|email|max:10',
      'password' => 'required|' . Cpf::class,
    ]);


    if ($validated->hasErrors()) {
      // dd($request->session->all());
      // return back();
      // dd($validated->errors());
      $request->session->flash()->set($validated->errors());
      return back();
      // return back()->with($validated->errors());
    }

    die();
  }
}
