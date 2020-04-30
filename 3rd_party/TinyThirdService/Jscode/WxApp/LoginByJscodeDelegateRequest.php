<?php


namespace API\ThirdService\WxApp;


class LoginByJscodeDelegateRequest {
  /**
   * @var string
   */
  public $openid;
  /**
   * @var string
   */
  public $unionid;
  /**
   * @var string
   */
  public $session_key;
}