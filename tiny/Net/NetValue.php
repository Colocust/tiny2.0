<?php declare(strict_types=1);


namespace Tiny;


class NetValue {
    public $owner;  //此token的拥有者(uid)

    public function __construct($owner) {
        $this->owner = $owner;
    }
}