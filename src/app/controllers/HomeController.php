<?php

namespace app\controllers;

use app\database\models\Post;
use core\library\Response;

class HomeController
{
  public function index(): Response
  {
    $posts = Post::limit(10)->get();

    $has = $posts->has(0);

    // dd($has);

    $collection = collect([1, 2, 3, 4, 5, 6]);

    $has = $collection->has(0);

    dd($has);

    // $result = $collection->pop();

    // $posts->each(function ($post) {
    //   dump($post->id);
    // });


    return view('home', [
      'title' => 'Home Page',
    ]);
  }
}
