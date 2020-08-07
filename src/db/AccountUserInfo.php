<?php declare(strict_types=1);


namespace TinyDB;


use Tiny\MongoDB\Info;

class AccountUserInfo extends Info {
    /**
     * @var string
     * @uses \Tiny\Annotation\Uses\Required
     */
    public $name;
    /**
     * @var string
     * @uses \Tiny\Annotation\Uses\Required
     */
    public $telephone;
}