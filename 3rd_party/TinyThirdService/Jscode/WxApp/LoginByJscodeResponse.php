<?php


namespace API\ThirdService\WxApp;


use API\LoginAPIResponse;

class LoginByJscodeResponse extends LoginAPIResponse {
  /**
   * @var string
   */
  public $errMsg;
  /**
   * @var string
   */
  public $uid;
}