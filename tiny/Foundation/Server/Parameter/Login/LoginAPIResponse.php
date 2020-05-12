<?php declare(strict_types=1);


namespace Tiny\Foundation\Server\Login;


use Tiny\Foundation\Server\Response;

class LoginAPIResponse extends Response {
  /**
   * @var string
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $token;
}