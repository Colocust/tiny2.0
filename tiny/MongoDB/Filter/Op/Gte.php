<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


class Gte extends OpStrategy {
  public function getValue() {
    return ['gte' => $this->value_];
  }
}