<?php

namespace core\database;

class Builder
{
  public static function getInstance()
  {
    return new self;
  }

  public function where(string $field, string $operator, string $value)
  {
    dd($field, $operator, $value);
  }
}
