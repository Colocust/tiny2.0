<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class Filter {
  private $filter = [];

  public function where(string $field, string $op, $value): self {
    $class = new Op($op, $value);
    $this->filter[$field] = $class->getValue();
    return $this;
  }

  public function in(string $field, array $value): self {
    $this->filter[$field] = ['$in' => $value];
    return $this;
  }

  public function or(string $field, string $op, $value): self {
    $class = new Op($op, $value);
    $this->filter['$or'][] = [$field => $class->getValue()];
    return $this;
  }

  public function getFilter(): array {
    return $this->filter;
  }
}