<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class Filter {
    private $filter = [];

    public function where(string $field, OpEnum $op, $value): self {
        $this->filter[$field] = $op->getOpStrategyValue($value);
        return $this;
    }

    public function in(string $field, array $value): self {
        $this->filter[$field] = ['$in' => $value];
        return $this;
    }

    public function or(string $field, OpEnum $op, $value): self {
        $this->filter['$or'][] = [$field => $op->getOpStrategyValue($value)];
        return $this;
    }

    public function getFilter(): array {
        return $this->filter;
    }
}