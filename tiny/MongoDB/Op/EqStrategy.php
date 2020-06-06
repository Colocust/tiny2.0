<?php


namespace Tiny\MongoDB\Op;


class EqStrategy extends OpStrategy {

  public function getOpValue() {
    return $this->value_;
  }
}