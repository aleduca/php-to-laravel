<?php

namespace core\database;

class DB
{
  public static function create(array $data)
  {
    $fields = implode(', ', array_keys($data));
    $values = implode(', ', array_map(function ($key) {
      return ":{$key}";
    }, array_keys($data)));

    return "INSERT INTO :table ({$fields}) VALUES ({$values})";
  }

  public static function update() {}

  public static function delete() {}
}
