<?php


namespace Tiny\MongoDB\Op;


class NeStrategy extends OpStrategy {

  public function getOpValue() {
    return ['$ne' => $this->value_];
  }
}