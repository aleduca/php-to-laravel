<?php

namespace app\controllers;

use app\database\models\Post;
use app\database\models\User;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $posts = Post::orderBy('id', 'desc')->limit(3)->with('user', 'category')->get();

    return view('home', [
      'title' => 'Home Page',
      'posts' => $posts->all()
    ]);
  }
}
