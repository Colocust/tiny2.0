<?php


namespace Tiny\MongoDB\Op;


class GtStrategy extends OpStrategy {

  public function getOpValue() {
    return ['$gt' => $this->value_];
  }
}