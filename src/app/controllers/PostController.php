<?php

namespace app\controllers;

use app\database\models\Post;

class PostController
{
  public function show(string $slug)
  {
    $post = Post::where('slug', $slug)->with('category', 'comments', 'user', 'tags')->first();

    return view('post/show', ['title' => 'Post', 'post' => $post]);
  }
}
