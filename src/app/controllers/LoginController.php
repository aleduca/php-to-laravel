<?php

namespace app\controllers;

use app\rules\Cpf;
use core\auth\Auth;
use core\library\Redirect;
use core\library\Request;

class LoginController
{
  public function __construct(
    private Auth $auth
  ) {}

  public function index(Request $request)
  {
    return view('login', [
      'title' => 'Login',
    ]);
  }

  public function store(Request $request)
  {
    $validated  = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    if ($validated->hasErrors()) {
      $request->session->flash()->set($validated->errors());
      return back();
    }

    if ($this->auth->attempt($request->get('email'), $request->get('password'))) {
      return redirect('/');
    }

    $request->session->flash()->set(['error' => 'Invalid credentials.']);
    return back();
  }

  public function destroy()
  {
    $this->auth->logout();

    return redirect('/');
  }
}
