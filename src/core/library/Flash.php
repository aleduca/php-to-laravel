<?php

namespace core\library;

use core\library\Session;

class Flash
{
  public function __construct(
    private Session $session
  ) {}

  public function set(
    array $data
  ) {
    $this->session->set('flash', $data);
  }

  public function get(
    string $key,
    string $style = 'alert alert-danger'
  ) {
    if ($this->session->has('flash.' . $key)) {
      $flash = $this->session->get('flash.' . $key);
      $this->session->remove('flash.' . $key);

      return "<span class='$style'>$flash</span>";
    }
  }
}
