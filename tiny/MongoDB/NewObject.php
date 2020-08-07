<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class NewObject {
    private $newObject = [];

    public function set(string $field, $value): self {
        $this->newObject['$set'][$field] = $value;
        return $this;
    }

    public function inc(string $field, int $value): self {
        $this->newObject['$inc'][$field] = $value;
        return $this;
    }

    public function unset(string $field): self {
        $this->newObject['$unset'][$field] = 1;
        return $this;
    }

    public function push(string $field, $value): self {
        $this->newObject['$push'][$field] = $value;
        return $this;
    }

    protected function addToSet(string $field, $value): self {
        $this->newObject['$addToSet'][$field] = $value;
        return $this;
    }

    protected function pop(string $field, $value): self {
        $this->newObject['$pop'][$field] = $value;
        return $this;
    }

    protected function pull(string $field, $value): self {
        $this->newObject['$pull'][$field] = $value;
        return $this;
    }

    public function getNewObject(): array {
        return $this->newObject;
    }
}