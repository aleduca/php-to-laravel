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
    // dd($request->all());
    if ($request->ajax()) {
      return response()->json(['message' => 'deleted ' . $id]);
    }
    dd('deleted ' . $id);
  }
}
