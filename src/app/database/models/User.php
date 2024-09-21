<?php

namespace app\database\models;

use core\database\Model;

class User extends Model
{
  // protected string $table = 'users';

  public function avatar()
  {
    return [
      'type' => 'hasOne',
      'model' => Avatar::class,
      'foreignKey' => 'user_id',
      'relation' => 'avatar'
    ];
  }
}
