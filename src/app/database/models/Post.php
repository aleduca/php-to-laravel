<?php

namespace app\database\models;

use app\database\models\Category;
use app\database\models\Comment;
use core\database\Model;

class Post extends Model
{

  public function user()
  {
    return [
      'type' => 'belongsTo',
      'model' => User::class,
      'foreignKey' => 'user_id',
      'relation' => 'user',
    ];
  }

  public function category()
  {
    return [
      'type' => 'belongsTo',
      'model' => Category::class,
      'foreignKey' => 'category_id',
      'relation' => 'category',
    ];
  }

  public function comments()
  {
    return [
      'type' => 'hasMany',
      'model' => Comment::class,
      'foreignKey' => 'post_id',
      'relation' => 'comments',
    ];
  }
}
