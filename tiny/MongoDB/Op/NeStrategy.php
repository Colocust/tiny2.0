<?php


namespace Tiny\MongoDB\Op;


class NeStrategy extends OpStrategy {

    public function getValue() {
        return ['$ne' => $this->value_];
    }
}