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

  /**
   * @var array
   */
  private array $bindings = [];

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

  public function where(string $field, string $operator, string $value)
  {
    dd($this->table);
    dd($field, $operator, $value);
  }

  private function handleStmt(string $sql)
  {
    $stmt = Connection::getInstance()->prepare($sql);
    return $stmt->execute($this->bindings);
  }

  public function execute(string $sql = '')
  {
    if (empty($sql)) {
      return;
    }

    dd($sql, $this->bindings);

    return $this->handleStmt($sql);
  }
}
