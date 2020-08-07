<?php


namespace Tiny\MongoDB;


use Tiny\Enum\Enum;
use Tiny\MongoDB\Op\EqStrategy;
use Tiny\MongoDB\Op\GteStrategy;
use Tiny\MongoDB\Op\GtStrategy;
use Tiny\MongoDB\Op\LteStrategy;
use Tiny\MongoDB\Op\LtStrategy;
use Tiny\MongoDB\Op\NeStrategy;
use Tiny\MongoDB\Op\OpStrategy;

class OpEnum extends Enum {
    const EQ = EqStrategy::class;
    const GT = GtStrategy::class;
    const GTE = GteStrategy::class;
    const LT = LtStrategy::class;
    const LTE = LteStrategy::class;
    const NE = NeStrategy::class;

    public function getOpStrategyValue($value) {
        $class = $this->getValue();
        /**
         * @var $strategy OpStrategy
         */
        $strategy = new $class($value);
        return $strategy->getValue();
    }

    public function __construct(string $op) {
        parent::__construct($op);
    }
}