<?php

namespace core\database;

use Doctrine\Inflector\InflectorFactory;

class Builder
{
  use DBCrud;
  /**
   * @var string
   */
  private string $table;

  /**
   * @var Model
   */
  private Model $model;

  public static function getInstance(Model $model)
  {
    $newSelf = new self();
    $newSelf->model = $model;
    $newSelf->setTable();

    return $newSelf;
  }

  private function setTable(): void
  {
    $reflect = new \ReflectionClass($this->model);

    if (!$reflect->hasProperty('table')) {
      $inflector = InflectorFactory::create()->build();
      $this->table = strtolower(
        $inflector->tableize(
          $inflector->pluralize($reflect->getShortName())
        )
      );

      return;
    }
    $this->table = $reflect->getProperty('table')->getValue(
      $this->model
    );
  }

  public function table(
    string $table
  ): self {

    $this->table = $table;

    return $this;
  }

  public function save()
  {
    $attributes = $this->model->attributes();
    if (!array_key_exists('id', $attributes)) {
      $this->create($attributes);
      return;
    }
    dd('update');
  }

  public function where(string $field, string $operator, string $value)
  {
    dd($this->table);
    dd($field, $operator, $value);
  }
}
