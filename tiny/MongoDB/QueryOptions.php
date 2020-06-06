<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class QueryOptions {
  private $options = [];


  public function limit(int $limit): self {
    $this->options['limit'] = $limit;
    return $this;
  }

  public function sort(string $field, int $sort): self {
    $this->options['sort'] = [$field => $sort];
    return $this;
  }

  public function projection(string $field): self {
    $this->options['projection'][$field] = 1;
    return $this;
  }

  public function getQueryOptions(): array {
    return $this->options;
  }
}