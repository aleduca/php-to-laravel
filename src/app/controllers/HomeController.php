<?php

namespace app\controllers;

use app\database\models\Post;
use app\database\models\Tag;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $tags = Tag::limit(10)->with('posts')->get();

    dd($tags);

    return view('home', [
      'title' => 'Home Page',
    ]);
  }
}
