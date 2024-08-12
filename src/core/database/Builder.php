<?php

namespace core\database;

use Doctrine\Inflector\InflectorFactory;

class Builder
{
  private string $table;

  public static function getInstance(string $model)
  {
    $newSelf = new self;
    $newSelf->setTable($model);

    return $newSelf;
  }

  private function setTable(string $model): void
  {
    $reflect = new \ReflectionClass($model);

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
      $reflect->newInstance()
    );
  }

  public function table(
    string $table
  ): self {

    $this->table = $table;

    return $this;
  }

  public function where(string $field, string $operator, string $value)
  {
    dd($this->table);
    dd($field, $operator, $value);
  }
}
