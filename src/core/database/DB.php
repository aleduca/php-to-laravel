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

  public static function update(array $data, array $where)
  {
    $fields = implode(',', array_map(function ($field) {
      return "{$field} = :{$field}";
    }, array_keys($data)));

    $where = array_map(function ($field) {
      return "{$field} = :{$field}";
    }, array_keys($where));

    return "UPDATE :table SET {$fields} WHERE " . implode(' AND ', $where);
  }

  public static function delete(array $where)
  {
    $where = array_map(function ($field) {
      return "{$field} = :{$field}";
    }, array_keys($where));

    return "DELETE FROM :table WHERE " . implode(' AND ', $where);
  }
}
