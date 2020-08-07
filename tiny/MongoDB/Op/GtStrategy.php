<?php


namespace Tiny\MongoDB\Op;


class GtStrategy extends OpStrategy {

    public function getValue() {
        return ['$gt' => $this->value_];
    }
}