<?php

namespace app\controllers;

use core\library\Request;

class CommentController
{
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email|domain|repeatedLetters:3',
      'comment' => 'required',
    ]);

    if ($validated->hasErrors()) {
      return back()->with($validated->errors());
    }

    // 7/7/2024 15:41:21
    // 7/7/2024 15:42:21
    if (!timerExpired('timer')) {
      return back()->with(['error' => 'You are posting too fast. Please wait a few seconds.']);
    }

    dd($validated);
  }
}
