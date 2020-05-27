<?php declare(strict_types=1);


namespace Tiny\MongoDB\Filter\Op;


abstract class OpStrategy {
  protected $value_;

  abstract public function getValue();

  public function __construct($value) {
    $this->value_ = $value;
  }
}