<?php


namespace Tiny\MongoDB\Op;

abstract class OpStrategy {
    abstract public function getValue();

    public function __construct($value) {
        $this->value_ = $value;
    }

    protected $value_;
}