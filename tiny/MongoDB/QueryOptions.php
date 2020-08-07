<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class QueryOptions {
    private $options = [];

    public function limit(int $limit): self {
        $this->options['limit'] = $limit;
        return $this;
    }

    public function sort(string $field, SortEnum $sort): self {
        $this->options['sort'] = [$field => $sort->getValue()];
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