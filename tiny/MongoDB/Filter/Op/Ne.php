<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


class Ne extends OpStrategy {

  public function getValue() {
    return ['$ne' => $this->value_];
  }
}