<?php

namespace app\database\models;

use core\database\Model;

class Reply extends Model
{
  public function comment(): array
  {
    return [
      'type' => 'belongsTo',
      'model' => Comment::class,
      'foreignKey' => 'comment_id',
      'relation' => 'comment'
    ];
  }

  public function user():array
  {
    return [
      'type' => 'belongsTo',
      'model' => User::class,
      'foreignKey' => 'user_id',
      'relation' => 'user'
    ];
  }
}