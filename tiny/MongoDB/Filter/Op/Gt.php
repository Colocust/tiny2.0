<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


class Gt extends OpStrategy {

  public function getValue() {
    return ['gt' => $this->value_];
  }
}