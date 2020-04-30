<?php


namespace API;


class LoginAPIResponse extends Response {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $token;
}