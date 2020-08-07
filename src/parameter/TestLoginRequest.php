<?php declare(strict_types=1);


namespace API;


use Tiny\Http\Login\LoginAPIRequest;

class TestLoginRequest extends LoginAPIRequest {
    /**
     * @var string
     * @uses \Tiny\Annotation\Uses\Required
     */
    public $uid;
}