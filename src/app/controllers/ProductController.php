<?php

namespace app\controllers;

use app\library\Email;

class ProductController
{
  public function show(
    string $product,
    Email $email
  ) {
    dd($email, $product);
  }
}
