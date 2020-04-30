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

  public function getOp(string $op, $value) {
    $op = self::OP[$op];
    /**
     * @var $opClass OpStrategy
     */
    $opClass = new $op($value);
    return $opClass->getOpValue();
  }
}