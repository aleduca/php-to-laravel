<?php

namespace core\database;

trait DBCrud
{
  public function create(array $attributes)
  {
    $response = DB::create($attributes);
    $sql = str_replace(':table', $this->table, $response);

    $this->bindings = $attributes;

    return $this->executeStmt($sql)->rowCount();
  }

  public function update(array $data, array $where)
  {
    $sql = DB::update($data, $where);
    $sql = str_replace(':table', $this->table, $sql);

    $this->bindings = [...$data, ...$where];

    return $this->executeStmt($sql)->rowCount();;
  }

  public function delete(array $where)
  {
    $sql = DB::delete($where);
    $sql = str_replace(':table', $this->table, $sql);

    $this->bindings = $where;

    return $this->executeStmt($sql)->rowCount();
  }

  public function save()
  {
    $attributes = $this->model->attributes();
    if (!array_key_exists('id', $attributes)) {
      return $this->create($attributes);
    }
    $where = ['id' => $attributes['id']];
    unset($attributes['id']);
    return $this->update($attributes, $where);
  }
}
