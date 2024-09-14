<?php

namespace app\controllers;

use app\database\models\Post;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $posts = Post::with('user', 'category')->where('id', '>', 10)->paginate(10);

    dd($posts);

    return view('home', [
      'title' => 'Home Page',
    ]);
  }
}
