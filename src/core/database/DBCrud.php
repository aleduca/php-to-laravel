<?php

namespace core\database;

trait DBCrud
{
  public function create(array $attributes)
  {
    $response = DB::create($attributes);
    $sql = str_replace(':table', $this->table, $response);

    dd($sql);
  }

  public function update() {}

  public function delete() {}
}
