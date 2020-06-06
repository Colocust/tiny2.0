<?php


namespace Tiny\MongoDB\Op;


class GteStrategy extends OpStrategy {

  public function getValue() {
    return ['$gte' => $this->value_];
  }
}