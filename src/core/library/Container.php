<?php

namespace core\library;

class Container
{
  private static array $container = [];

  public static function bind(
    string $key,
    mixed $value
  ) {
    static::$container[$key] = $value;
  }

  public static function resolve(
    string $key
  ) {
    if (!array_key_exists($key, static::$container)) {
      return null;
    }

    if (is_callable(static::$container[$key])) {
      return static::$container[$key]();
    }

    return static::$container[$key];
  }
}
