<?php

namespace core\database;

use BadMethodCallException;

/**
 * @method static Builder limit(int|string $limit)
 * @method static Builder select()
 * @method static object|false find(string $field,mixed $value = '')
 * @method static Builder where(string $field, string $operator, string $value)
 * @method static Builder paginate(intb $perPage = 10)
 */
abstract class Model
{
  private array $attributes = [];
  private array $attributesChanged = [];

  public function __set(
    string $name,
    mixed $value
  ) {
    if (array_key_exists($name, $this->attributes)) {
      $this->attributesChanged[$name] = $value;
      return;
    }
    $this->attributes[$name] = $value;
  }

  public function __get(
    string $name
  ) {
    return $this->attributes[$name];
  }

  public function removeAttribute(string $name)
  {
    if (isset($this->attributes[$name])) {
      unset($this->attributes[$name]);
    }
  }

  public function attributes()
  {
    return $this->attributes;
  }

  public function attributesChanged()
  {
    return $this->attributesChanged;
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
