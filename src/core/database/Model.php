<?php

namespace core\database;

use BadMethodCallException;

/**
 * @method static Builder where(string $field, string $operator, string $value)
 */
abstract class Model
{
  private array $attributes = [];

  public function __set(
    string $name,
    mixed $value
  ) {
    $this->attributes[$name] = $value;
  }

  public function __get(
    string $name
  ) {
    return $this->attributes[$name];
  }

  public function attributes()
  {
    return $this->attributes;
  }

  public static function newQueryBuilder(Model $model)
  {
    return Builder::getInstance($model);
  }

  public function __call(string $name, array $arguments)
  {
    $queryBuilder = self::newQueryBuilder($this);
    if (!method_exists($queryBuilder, $name)) {
      throw new BadMethodCallException("Method {$name} does not exist in Builder class");
    }
    return $queryBuilder->$name(...$arguments);
  }

  public static function __callStatic(string $name, array $arguments)
  {
    return (new static)->$name(...$arguments);
  }
}
