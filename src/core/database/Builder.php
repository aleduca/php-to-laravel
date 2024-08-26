<?php

namespace core\database;

use core\library\Paginate;
use Doctrine\Inflector\InflectorFactory;
use PDO;
use stdClass;

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


  /**
   * @var int
   */
  private int|string $offset = '';

  /**
   * @var int|string
   */
  private int|string $limit = '';

  /**
   * @var string
   */
  private string $orderBy = '';

  /**
   * @var string
   */
  private string $groupBy = '';

  /**
   * @var Paginate
   */
  private ?Paginate $paginate = null;

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
    if ($this->paginate) {
      $stdclass = new stdClass;
      $stdclass->items = $this->executeStmt($sql)->fetchAll(PDO::FETCH_CLASS, $this->model::class);
      $stdclass->paginate = $this->paginate;
      $stdclass->total = $this->paginate->total;
      return $stdclass;
    }

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

  public function groupBy(
    string $field
  ) {
    $this->groupBy = " GROUP BY {$field}";

    return $this;
  }

  public function orderBy(
    string $field,
    string $order = 'ASC'
  ) {
    $this->orderBy = " ORDER BY {$field} {$order}";

    return $this;
  }

  public function offset(int $offset)
  {
    $this->offset = ' OFFSET ' . $offset;

    return $this;
  }

  public function limit(int|string $limit)
  {
    $this->limit = ' LIMIT ' . $limit;

    return $this;
  }

  public function find(
    string $field,
    mixed $value = ''
  ) {
    if (func_num_args() === 2) {
      return $this->where($field, $value)->first();
    }

    return $this->where('id', $field)->first();
  }

  private function count()
  {
    $sql = "SELECT COUNT(*) FROM {$this->table}";
    $sql .= implode(' ', $this->wheres);
    return $this->executeStmt($sql)->fetchColumn();
  }

  public function paginate(int $perPage = 10)
  {
    $count = $this->count();
    // dd($count);
    $this->paginate = new Paginate;
    $this->paginate->currentPage();
    $this->paginate->offset($perPage);
    $this->paginate->totalPages($count);

    $this->limit($perPage);
    $this->offset($this->paginate->offset);

    return $this->get();
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
    $sql .= $this->groupBy;
    $sql .= $this->orderBy;
    $sql .= $this->limit;
    $sql .= $this->offset;

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
