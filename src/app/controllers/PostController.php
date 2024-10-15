<?php

namespace app\controllers;

use app\database\models\Post;

class PostController
{
  public function show(string $slug)
  {
    $post = Post::where('slug', $slug)->with(
      'category', 'comments.user.avatar', 'user.avatar','comments.replies.user.avatar',
      'tags')->first();

//    dd($post);

    return view('post/show', ['title' => 'Post', 'post' => $post]);
  }
}
