<?php


namespace API\ThirdService\WxApp;

use Tiny\Curl;
use Tiny\Logger;

class WxHelper {
  public static function jscode2session(string $jscode, string $appid, string $secret): ?WxSession {
    Logger::getInstance()->info("request jscode2session from wx with jscode($jscode) and appid($appid)");

    $url = "https://api.weixin.qq.com/sns/jscode2session?appid="
      . $appid . "&secret=" . $secret . "&js_code=" . $jscode
      . "&grant_type=authorization_code";

    $res = Curl::curlGet($url);

    if ($res === false) {
      Logger::getInstance()->error("wx jscode2session curl error");
      return null;
    }

    $obj = json_decode($res);

    if (isset($obj->errcode)) {
      Logger::getInstance()->error("wx jscode2session response error, errorcode("
        . $obj->errcode . ") and errormsg(" . $obj->errmsg . ")");
      return null;
    }

    if (!isset($obj->openid) || !isset($obj->session_key)) {
      Logger::getInstance()->error("wx jscode2session response error, unknow error, response is " . $res);
      return null;
    }

    $session = new WxSession($obj->openid, $obj->session_key, $obj->unionid ?? null);

    return $session;
  }
}