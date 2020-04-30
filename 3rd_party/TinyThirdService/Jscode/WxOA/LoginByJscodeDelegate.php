<?php


namespace API\ThirdService\WxOA;


interface LoginByJscodeDelegate {
  public static function getAppId(): string;

  public static function getAppSecret(): string;

  public static function login(LoginByJscodeDelegateRequest $delegateRequest): LoginByJscodeDelegateResponse;
}