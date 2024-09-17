<?php

namespace app\controllers;

use app\database\models\Post;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $posts = Post::limit(10)->with('user', 'category', 'comments')->where('id', '>', 10)->get();

    dd($posts);

    return view('home', [
      'title' => 'Home Page',
    ]);
  }
}
