<?php

namespace core\library;

class Response
{
  public function __construct(
    private string $content = '',
    private int $status = 200,
    private array $headers = []
  ) {
  }

  public function json(
    array $data
  ) {
    $this->headers['Content-Type'] = 'application/json';

    $this->content = json_encode($data);

    return $this;
  }

  public function send()
  {
    http_response_code($this->status);

    foreach ($this->headers as $key => $header) {
      header($key . ': ' . $header);
    }

    echo $this->content;
  }
}