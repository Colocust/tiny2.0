<?php


namespace Tiny\MongoDB\Op;


class LteStrategy extends OpStrategy {

  public function getOpValue() {
    return ['$lte' => $this->value_];
  }
}