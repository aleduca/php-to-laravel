<?php

namespace app\controllers;

use core\library\Request;

class UserController
{
  public function store()
  {
    dd('store');
  }

  public function destroy(int $id, Request $request)
  {
    dd($request->all());
    // dd('deleted ' . $id);
  }
}
