<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


class Lt extends OpStrategy {

  public function getValue() {
    return ['lt' => $this->value_];
  }
}