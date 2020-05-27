<?php declare(strict_types=1);


namespace MongoDB\Filter;


use Tiny\MongoDB\Filter\Op\Eq;
use Tiny\MongoDB\Filter\Op\OpStrategy;

class Op {

  const STRATEGY_CLASS = [
    '=' => Eq::class
  ];

  public function __construct(string $op, $value) {
    $className = self::STRATEGY_CLASS[$op];
    $this->class_ = new $className($value);
  }

  /**
   * @var $class_ OpStrategy
   */
  public $class_;
}