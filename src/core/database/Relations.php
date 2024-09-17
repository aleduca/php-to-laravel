<?php

namespace core\database;

use PDO;

trait Relations
{
  private array $relations = [];

  public function with(array|string $relations): static
  {
    $this->relations = is_array($relations) ? $relations : func_get_args();

    return $this;
  }

  private function setRelations(array $data)
  {
    if (empty($this->relations)) {
      return;
    }

    $this->resetBindingsSql();

    foreach ($this->relations as $relation) {
      $responseRelation = $this->model->{$relation}();

      $this->{$responseRelation['type']}($data, $responseRelation);
    }
  }

  private function belongsTo(array $data, array $relation)
  {
    $this->setTable($relation['model']);

    $ids = array_map(function ($item) use ($relation) {
      return $item->{$relation['foreignKey']};
    }, $data);

    $sql = "SELECT * FROM {$this->table} where id IN(" . implode(',', $ids) . ")";

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];
    foreach ($relatedItems as $relatedItem) {
      $relatedMap[$relatedItem->id] = $relatedItem;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->{$relation['foreignKey']}];
    }
  }

  private function hasMany(array $data, array $relation)
  {
    $this->setTable($relation['model']);

    $ids = array_map(function ($item) {
      return $item->id;
    }, $data);

    $sql =  "SELECT * FROM {$this->table} where {$relation['foreignKey']} IN(" . implode(',', $ids) . ")";

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];
    foreach ($relatedItems as $item) {
      $relatedMap[$item->{$relation['foreignKey']}][] = $item;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->id] ?? [];
    }
  }
}
