<?php

namespace core\database;

use Doctrine\Inflector\InflectorFactory;
use PDO;

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

  /**
   * @var string
   */
  private string $select = '*';

  /**
   * @var array
   */
  private array $wheres = [];

  /**
   * @var string
   */
  private string $whereLogicOperator;

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

  public function all()
  {
    $sql = "SELECT * FROM {$this->table}";
    return $this->get($sql);
  }

  public function get(string $sql = '')
  {
    return $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $this->model::class);
  }

  public function first(string $sql = '')
  {
    return $this->executeStmt($sql)->fetchObject($this->model::class);
  }

  public function select()
  {
    $this->select = (func_num_args() === 0) ? '*' : implode(', ', func_get_args());
    return $this;
  }

  public function and()
  {
    $this->whereLogicOperator = 'AND';

    return $this;
  }

  public function or()
  {
    $this->whereLogicOperator = 'OR';

    return $this;
  }

  public function where(string $field, string $operator, string $value = '')
  {
    $where = empty($this->wheres) ?  ' WHERE' : $this->whereLogicOperator;

    if (func_num_args() === 2) {
      $value = $operator;
      $operator = '=';
    }

    // WHERE id = :id
    $this->wheres[] = "{$where} {$field} {$operator} :{$field}";

    $this->bindings = [
      ...$this->bindings,
      $field => $value
    ];

    return $this;
  }

  private function buildQuery()
  {
    $sql = "SELECT {$this->select} FROM {$this->table}";

    $sql .= implode(' ', $this->wheres);

    // dd($sql, $this->bindings);

    return $sql;
  }

  private function executeStmt(string $sql = '')
  {
    if (empty($sql)) {
      $sql = $this->buildQuery();
    }

    // dd($sql, $this->bindings);

    return $this->getStmt($sql);
  }

  private function getStmt(string $sql)
  {
    $stmt = Connection::getInstance()->prepare($sql);
    $stmt->execute($this->bindings);
    return $stmt;
  }
}
