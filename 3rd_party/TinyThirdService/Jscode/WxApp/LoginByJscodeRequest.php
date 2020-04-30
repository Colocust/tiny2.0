<?php


namespace API\ThirdService\WxApp;


use API\LoginAPIRequest;

class LoginByJscodeRequest extends LoginAPIRequest {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $jscode;
}