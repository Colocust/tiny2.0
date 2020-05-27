<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


class Lte extends OpStrategy {

  public function getValue() {
    return ['$lte' => $this->value_];
  }
}