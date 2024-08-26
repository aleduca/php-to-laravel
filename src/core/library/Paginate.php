<?php

namespace core\library;

class Paginate
{
  public readonly int $currentPage;
  public readonly int $perPage;
  public readonly int $offset;
  public readonly int $totalPages;
  public readonly int $total;

  public function currentPage()
  {
    $this->currentPage = $_GET['page'] ?? 1;
  }

  public function offset(int $perPage)
  {
    $this->perPage = $perPage;
    // 3 - 1 = 2 * 5 = 10
    $this->offset = ($this->currentPage - 1) * $perPage;
  }

  public function totalPages(int $count)
  {
    // 90 / 10 = 9
    $this->total = $count;
    $this->totalPages = ceil($count / $this->perPage);
  }

  public function simpleLinks()
  {
    if ($this->totalPages <= 1) {
      return '';
    }

    $links = '<ul class="pagination">';
    if ($this->currentPage > 1) {
      $links .= '<li class="page-item"><a class="page-link" href="?page=1">First</a></li>';
      $links .= '<li class="page-item"><a class="page-link" href="?page=' . ($this->currentPage - 1) . '">Previous</a></li>';
    }
    if ($this->currentPage < $this->totalPages) {
      $links .= '<li class="page-item"><a class="page-link" href="?page=' . ($this->currentPage + 1) . '">Next</a></li>';

      $links .= '<li class="page-item"><a class="page-link" href="?page=' . $this->totalPages . '">Last</a></li>';
    }

    $links .= '</ul>';

    return $links;
  }

  public function links()
  {
    $totalPages = $this->totalPages;
    $startPage = max(1, $this->currentPage - $this->perPage);
    $endPage = min($totalPages, $this->currentPage + $this->perPage);

    $links = '<ul class="pagination mt-3">';

    if ($this->currentPage > 1) {
      $links .= '<li class="page-item"><a href="?page=1" class="page-link">First</a></li>';
    }

    for ($i = $startPage; $i <= $endPage; $i++) {
      $links .= '<li';
      if ($i == $this->currentPage) {
        $links .= ' class="active page-item"';
      }
      $links .= '><a href="?page=' . $i . '" class="page-link">' . $i . '</a></li>';
    }

    if ($this->currentPage < $totalPages) {
      $links .= '<li class="page-item"><a href="?page=' . $totalPages . '" class="page-link">Last</a></li>';
    }

    $links .= '</ul>';

    return $links;
  }
}
