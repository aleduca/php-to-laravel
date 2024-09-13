<?php

namespace core\library;

use ArgumentCountError;
use Closure;

class Collection
{
  public function __construct(
    private array $items = []
  ) {}

  public function pluck()
  {
    if (func_num_args() !== 1) {
      throw new ArgumentCountError('The pluck method requires exactly one argument');
    }

    $pluck = func_get_args()[0];

    $data = array_map(function ($item) use ($pluck) {
      return $item->{$pluck};
    }, $this->items);

    $this->items = $data;

    return $data;
  }
  public function pop()
  {
    return array_pop($this->items);
  }
  public function each(Closure $callback)
  {
    foreach ($this->items as $item) {
      $callback($item);
    }
  }
  public function implode(Closure $callback, string $separator = ',')
  {
    $mapped = array_map(
      function ($value, $key) use ($callback) {
        return $callback($value, $key);
      },
      $this->items,
      array_keys($this->items)
    );

    return implode($separator, $mapped);
  }

  public function has(int $key)
  {
    return array_key_exists($key, $this->items);
  }

  public function all()
  {
    return $this->items;
  }
}
