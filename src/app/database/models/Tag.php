<?php

namespace app\database\models;

use core\database\Model;

class Tag extends Model
{
  public function posts()
  {
    return [
      'type' => 'belongsToMany',
      'model' => Post::class,
      'pivotTable' => 'post_tag',
      'foreignKey' => 'tag_id',
      'relatedKey' => 'post_id',
      'relation' => 'posts',
    ];
  }
}
