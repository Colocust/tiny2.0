<?php


namespace Tiny\MongoDB;


use Tiny\MongoDB\Op\EqStrategy;
use Tiny\MongoDB\Op\GteStrategy;
use Tiny\MongoDB\Op\GtStrategy;
use Tiny\MongoDB\Op\LteStrategy;
use Tiny\MongoDB\Op\LtStrategy;
use Tiny\MongoDB\Op\NeStrategy;
use Tiny\MongoDB\Op\OpStrategy;

class Op {

  const OP = [
    '=' => EqStrategy::class,
    '>' => GtStrategy::class,
    '>=' => GteStrategy::class,
    '<' => LtStrategy::class,
    '<=' => LteStrategy::class,
    '!=' => NeStrategy::class
  ];

  public function getValue() {
    $class = self::OP[$this->op_];

    /**
     * @var $strategy OpStrategy
     */
    $strategy = new $class($this->value_);
    return $strategy->getValue();
  }

  public function __construct(string $op, $value) {
    $this->op_ = $op;
    $this->value_ = $value;
  }

  private $op_;
  private $value_;
}