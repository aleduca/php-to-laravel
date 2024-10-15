<?php

namespace app\controllers;

use app\database\models\Post;
use app\database\models\User;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $posts = Post::orderBy('id', 'desc')->limit(3)->with('user.avatar',
      'user.comments', 'category', 'comments.user.avatar')->get();

    // 'user' => ['avatar' => [],'comments' => []]
    // 'comments' => ['user' => ['avatar' => []]]

    return view('home', [
      'title' => 'Home Page',
      'posts' => $posts->all()
    ]);
  }
}
