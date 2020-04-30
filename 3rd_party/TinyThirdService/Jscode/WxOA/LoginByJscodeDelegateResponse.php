<?php


namespace API\ThirdService\WxOA;


use API\LoginAPIState;

class LoginByJscodeDelegateResponse {
  /**
   * @var string
   */
  public $uid;
  /**
   * @var LoginAPIState
   */
  public $state;
  /**
   * @var string
   */
  public $errMsg;
}