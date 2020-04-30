<?php


namespace API\ThirdService\WxApp;

interface LoginByJscodeDelegate {
  public static function getAppId(): string;

  public static function getAppSecret(): string;

  public static function login(LoginByJscodeDelegateRequest $delegateRequest): LoginByJscodeDelegateResponse;
}