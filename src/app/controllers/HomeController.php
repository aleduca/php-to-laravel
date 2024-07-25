<?php

namespace app\controllers;

use core\library\Redirect;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    // $redirect = resolve(Redirect::class);
    // dd($redirect);
    return view('home', [
      'title' => 'Home Page',
      'name' => 'Alexandre'
    ]);
  }
}
