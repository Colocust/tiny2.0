<?php


namespace API\ThirdService\WxApp;


class WxSession {
  public $openid;
  public $session_key;
  public $unionid;

  public function __construct(string $openid, string $session_key, ?string $unionid = null) {
    $this->openid = $openid;
    $this->session_key = $session_key;
    $this->unionid = $unionid;
  }
}