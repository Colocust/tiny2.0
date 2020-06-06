<?php


namespace Tiny\MongoDB\Op;


class LteStrategy extends OpStrategy {

  public function getValue() {
    return ['$lte' => $this->value_];
  }
}