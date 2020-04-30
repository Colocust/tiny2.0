<?php


namespace API\ThirdService\WxApp;


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