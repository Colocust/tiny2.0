<?php


namespace Tiny\MongoDB\Op;


class GteStrategy extends OpStrategy {

  public function getOpValue() {
    return ['$gte' => $this->value_];
  }
}