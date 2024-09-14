<?php

namespace app\database\models;

use app\database\models\Category;
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
}
