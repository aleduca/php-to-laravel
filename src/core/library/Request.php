<?php

namespace core\library;

use core\library\Validate;

class Request
{
  public function __construct(
    public readonly array $server,
    public readonly array $get,
    public readonly array $post,
    public Session $session,
    public readonly array $cookies,
    public readonly array $headers,
  ) {
    $this->session->csrf()->check($this);
  }

  public static function create(Session $session)
  {
    return new static(
      $_SERVER,
      $_GET,
      $_POST,
      $session,
      $_COOKIE,
      getallheaders(),
    );
  }

  public function validate(
    array $rules
  ): Validate {
    return (new Validate)->validate($rules, $this);
  }

  public function get(
    string $name
  ): ?string {
    $httpMethod = strtolower($this->server['REQUEST_METHOD']);

    if (!isset($this->$httpMethod[$name])) {
      return null;
    }

    if ($httpMethod) {
      return strip_tags($this->$httpMethod[$name]);
    }

    return null;
  }

  public function all(): array
  {
    $httpMethod = strtolower($this->server['REQUEST_METHOD']);

    $data = [];

    foreach ($this->$httpMethod as $key => $value) {
      if (in_array($key, ['_method', 'csrf'])) {
        continue;
      }
      $data[$key] = strip_tags($value);
    }

    return $data;
  }
}
