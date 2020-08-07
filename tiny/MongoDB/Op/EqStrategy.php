<?php


namespace Tiny\MongoDB\Op;


class EqStrategy extends OpStrategy {

    public function getValue() {
        return $this->value_;
    }
}