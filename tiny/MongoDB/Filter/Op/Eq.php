<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


use MongoDB\Filter\Op;

class Eq extends OpStrategy {

  public function getValue() {
    return $this->value_;
  }
}