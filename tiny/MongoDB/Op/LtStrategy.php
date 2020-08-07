<?php


namespace Tiny\MongoDB\Op;


class LtStrategy extends OpStrategy {

    public function getValue() {
        return ['$lt' => $this->value_];
    }
}