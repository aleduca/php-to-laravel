<?php

namespace core\library;

class Session
{
  public function has(
    string $key
  ): bool {
    if (str_contains($key, '.')) {
      [$key1, $key2] = explode('.', $key);
      return isset($_SESSION[$key1][$key2]);
    }
    return isset($_SESSION[$key]);
  }

  public function set(
    string $key,
    mixed $value
  ): void {
    if (str_contains($key, '.')) {
      [$key1, $key2] = explode('.', $key);
      $_SESSION[$key1][$key2] = $value;
      return;
    }

    $_SESSION[$key] = $value;
  }

  public function get(
    string $key
  ): mixed {
    if (str_contains($key, '.')) {
      [$key1, $key2] = explode('.', $key);
      return $_SESSION[$key1][$key2];
    }

    return $_SESSION[$key];
  }

  public function all(): array
  {
    return $_SESSION;
  }

  public function remove(
    string $key
  ): void {
    if ($this->has($key)) {
      if (str_contains($key, '.')) {
        [$key1, $key2] = explode('.', $key);
        unset($_SESSION[$key1][$key2]);
        return;
      }

      unset($_SESSION[$key]);
    }
  }

  public function previousUrl()
  {
  }
}
