<?php

namespace core\database;

use BadMethodCallException;

/**
 * @method static Builder where(string $field, string $operator, string $value)
 */
abstract class Model
{
  public static function newQueryBuilder()
  {
    return Builder::getInstance(static::class);
  }

  public function __call(string $name, array $arguments)
  {
    $queryBuilder = self::newQueryBuilder();
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
