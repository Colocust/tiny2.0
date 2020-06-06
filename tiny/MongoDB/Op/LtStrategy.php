<?php


namespace Tiny\MongoDB\Op;


class LtStrategy extends OpStrategy {

  public function getOpValue() {
    return ['$lt' => $this->value_];
  }
}