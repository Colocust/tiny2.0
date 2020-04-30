<?php


namespace API\ThirdService\WxOA;


class WxSession {
  public $access_token;
  public $openid;
  public $scope;
  public $refresh_token;
  public $expires_in;

  public function __construct(string $access_token, string $openid, string $scope, string $refresh_token, int $expires_in) {
    $this->access_token = $access_token;
    $this->openid = $openid;
    $this->scope = $scope;
    $this->refresh_token = $refresh_token;
    $this->expires_in = $expires_in;
  }
}