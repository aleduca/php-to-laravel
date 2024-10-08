<?php

namespace app\database\models;

use core\database\Model;

class Comment extends Model
{
  public function user()
  {
    return [
      'type' => 'belongsTo',
      'model' => User::class,
      'foreignKey' => 'user_id',
      'relation' => 'user'
    ];
  }
}
