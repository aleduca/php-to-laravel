<?php

namespace app\controllers;

class PostController
{
  public function show(string $slug)
  {
    // dump($slug);
    return view('post/show', ['title' => 'Post']);
  }
}
