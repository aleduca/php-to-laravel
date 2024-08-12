<?php

namespace app\controllers;

use app\library\Email;
use core\library\Request;
use core\library\Response;

class ProductController
{
  public function show(
    string $product,
  ) {

    // dd($product, $email);
    // return 'Product: ' . $product;
    // return 'Product: ' . $product;
    return [1, 2, 3, 4, 5, 6];
    // return view('product', [
    //   'product' => $product,
    // ]);
    // return (new Response(
    //   view('product', [
    //     'product' => $product,
    //   ]),
    // ))->send();
  }
}
