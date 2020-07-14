<?php declare(strict_types=1);


namespace Tiny\Http\Login;



use Tiny\Http\Response;

class LoginAPIResponse extends Response {
  /**
   * @var string
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $token;
}