<?php

namespace app\controllers;

class UserController
{
  public function store()
  {
    dd('store');
  }

  public function destroy(int $id)
  {
    dd('deleted ' . $id);
  }
}
