<?php

namespace core\database;

use Exception;
use PDO;

trait Relations
{
  private array $relations = [];
  private array $subRelations = [];

  public function with(array|string $relations): static
  {
    $relations = is_array($relations) ? $relations : func_get_args();

    foreach ($relations as $relation) {
      if (str_contains($relation, '.')) {
        $subrelations = explode('.', $relation);
        if (count($subrelations) > 3) {
          throw new Exception("Maximum 3 levels of nested relations are allowed {$relation}");
        }


        if (!in_array($subrelations[0], $this->relations)) {
          $this->relations[] = $subrelations[0];
        }

        $this->setNestedRelations($subrelations);
      } else {
        // dump('relation ' . $relation);
        if (!in_array($relation, $this->relations)) {
          $this->relations[] = $relation;
        }
      }
    }

    // die();

    return $this;
  }

  private function setNestedRelations(array $subrelations)
  {
    if (count($subrelations) == 2) {
      $this->subRelations[$subrelations[0]][$subrelations[1]] = [];
      $this->subRelations[$subrelations[0]]['isNested'] = false;
    }

    if (count($subrelations) === 3) {
      $this->subRelations[$subrelations[0]][$subrelations[1]][$subrelations[2]] = [];
      $this->subRelations[$subrelations[0]]['isNested'] = true;
    }
  }

  private function setRelations(array $data)
  {
    if (empty($this->relations)) {
      return;
    }

    $this->resetBindingsSql();

    // dd($this->relations, $this->subRelations);
    foreach ($this->relations as $relation) {
      $responseRelation = $this->model->{$relation}();

      $this->{$responseRelation['type']}($data, $responseRelation);
    }
  }

  private function setSubRelations(array $relatedItems, array $relation)
  {
    $subRelation = $this->subRelations[$relation['relation']];
    $isNested = $subRelation['isNested'];
    $model = new $relation['model'];

    if (!$isNested) {
      while (!empty($subRelation)) {
        unset($subRelation['isNested']);
        $method = array_key_first($subRelation);
        array_shift($subRelation);
        $relationModel = $model->{$method}();
        $this->{$relationModel['type']}($relatedItems, $relationModel, true);
      }
      return;
    }

    unset($subRelation['isNested']);
    $method = array_key_first($subRelation);
    $relationModel = $model->{$method}();
    $relatedItems = $this->{$relationModel['type']}($relatedItems, $relationModel, true);

    $method = array_key_first($subRelation[$method]);
    $model = new $relationModel['model'];
    $relationModel = $model->{$method}();
    $this->{$relationModel['type']}($relatedItems, $relationModel);
  }

  private function belongsTo(array $data, array $relation, bool $returnItems = false)
  {
    $this->setTable($relation['model']);

    $ids = array_unique(array_map(function ($item) use ($relation) {
      return $item->{$relation['foreignKey']};
    }, $data));

    sort($ids);

    $sql = "SELECT * FROM {$this->table} where id IN(" . implode(',', $ids) . ")";

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];
    foreach ($relatedItems as $relatedItem) {
      $relatedMap[$relatedItem->id] = $relatedItem;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->{$relation['foreignKey']}];
    }

    if ($returnItems) {
      return $relatedItems;
    }

    // dd($relation, $this->subRelations);

    if (!$returnItems && array_key_exists($relation['relation'], $this->subRelations)) {
      $this->setSubRelations($relatedItems, $relation);
    }
  }

  private function hasMany(array $data, array $relation, bool $returnItems = false)
  {
    $this->setTable($relation['model']);

    $ids = array_unique(array_map(function ($item) {
      return $item->id;
    }, $data));

    sort($ids);

    $sql =  "SELECT * FROM {$this->table} where {$relation['foreignKey']} IN(" . implode(',', $ids) . ")";

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];
    foreach ($relatedItems as $item) {
      $relatedMap[$item->{$relation['foreignKey']}][] = $item;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->id] ?? [];
    }

    if ($returnItems) {
      return $relatedItems;
    }

    if (!$returnItems && array_key_exists($relation['relation'], $this->subRelations)) {
      $this->setSubRelations($relatedItems, $relation);
    }
  }

  private function belongsToMany(array $data, array $relation)
  {
    $this->setTable($relation['model']);

    $ids = array_unique(array_map(function ($item) {
      return $item->id;
    }, $data));

    sort($ids);

    $sql = "SELECT {$this->table}.*,{$relation['pivotTable']}.{$relation['foreignKey']},{$relation['pivotTable']}.{$relation['relatedKey']} FROM {$this->table} INNER JOIN {$relation['pivotTable']} ON {$relation['pivotTable']}.{$relation['relatedKey']} = {$this->table}.id WHERE {$relation['pivotTable']}.{$relation['foreignKey']} IN (" . implode(',', $ids) . ')';

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];
    foreach ($relatedItems as $item) {
      $relatedMap[$item->{$relation['foreignKey']}][] = $item;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->id] ?? [];
    }
  }

  private function hasOne(array $data, array $relation, bool $returnItems = false)
  {
    $this->setTable($relation['model']);

    $ids = array_unique(array_map(function ($item) {
      return $item->id;
    }, $data));

    sort($ids);

    $sql = "SELECT * FROM {$this->table} where {$this->table}.{$relation['foreignKey']} IN(" . implode(',', $ids) . ")";

    $relatedItems = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $relation['model']);

    $relatedMap = [];

    foreach ($relatedItems as $relatedItem) {
      $relatedMap[$relatedItem->{$relation['foreignKey']}] = $relatedItem;
    }

    foreach ($data as $item) {
      $item->{$relation['relation']} = $relatedMap[$item->id] ?? null;
    }

    if ($returnItems) {
      return $relatedItems;
    }

    if (!$returnItems && array_key_exists($relation['relation'], $this->subRelations)) {
      $this->setSubRelations($relatedItems, $relation);
    }
  }
}
