<?php


namespace API\ThirdService\WxOA;


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