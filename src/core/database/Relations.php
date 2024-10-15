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

        if (count($subrelations) > 4) {
          throw new Exception("Maximum 4 levels of nested relations are allowed {$relation}");
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

  private function setNestedRelations(array $subrelations): void
  {
    if (count($subrelations) == 2) {
      $this->subRelations[$subrelations[0]][$subrelations[1]] = [];
      $this->subRelations[$subrelations[0]][$subrelations[1]]['isNested'] = false;
    }

    if (count($subrelations) === 3) {
      $this->subRelations[$subrelations[0]][$subrelations[1]][$subrelations[2]] = [];
      $this->subRelations[$subrelations[0]][$subrelations[1]]['isNested'] = true;
    }

    if (count($subrelations) === 4) {
      $this->subRelations[$subrelations[0]][$subrelations[1]][$subrelations[2]][$subrelations[3]] = [];
      $this->subRelations[$subrelations[0]][$subrelations[1]]['isNested'] = true;
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

  private function setSubRelations(array $relatedItems, array $relation): void
  {
    $subRelations = $this->subRelations[$relation['relation']];

    foreach($subRelations as $method => $subRelation){
    $isNested = $subRelation['isNested'];
    $model = new $relation['model'];
      if (!$isNested) {
        while (!empty($subRelation)) {
          unset($subRelation['isNested']);
          array_shift($subRelation);
          $relationModel = $model->{$method}();
          $this->{$relationModel['type']}($relatedItems, $relationModel);
        }
      }

      $this->processNestedSubRelations(
        $subRelation,
        $relatedItems,
        $model,
        $method
      );

    }

  }

  private function processNestedSubRelations(
    array $subRelation,
    array $relatedItems,
    Model $model,
    string $method
  ): void {
    unset($subRelation['isNested']);

    // Obtem o model do relacionamento e executa o método adequado
    $relationModel = $model->{$method}();
    $relatedItems = $this->{$relationModel['type']}($relatedItems, $relationModel, true);

    // Obtém o próximo método do sub-relacionamento
    $nextMethod = array_key_first($subRelation);

    // Verifica se há um próximo método a ser processado
    if(!$nextMethod){
      return;
    }

    $subRelation = $subRelation[$nextMethod];
    unset($subRelation['isNested']);

    // Cria uma nova instancia do Model e processa o prócimo método
    $model = new $relationModel['model'];
    $this->processNestedSubRelations(
      $subRelation,
      $relatedItems,
      $model,
      $nextMethod);
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

    if (array_key_exists($relation['relation'], $this->subRelations)) {
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

    if (array_key_exists($relation['relation'], $this->subRelations)) {
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

    if (array_key_exists($relation['relation'], $this->subRelations)) {
      $this->setSubRelations($relatedItems, $relation);
    }
  }
}
