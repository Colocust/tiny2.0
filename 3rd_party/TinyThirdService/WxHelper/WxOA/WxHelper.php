<?php

namespace API\ThirdService\WxOA;

use Tiny\Curl;
use Tiny\Logger;

class WxHelper {

  public static function oauth2(string $jscode, string $appid, string $secret): ?WxSession {
    Logger::getInstance()->info("request jscode2session from wx with jscode($jscode) and appid($appid)");

    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid="
      . $appid . "&secret=" . $secret . "&code=" . $jscode
      . "&grant_type = authorization_code";

    $res = Curl::curlGet($url);

    if ($res === false) {
      Logger::getInstance()->error("wx oauth2 curl error");
      return null;
    }

    $obj = json_decode($res);

    if (isset($obj->errcode)) {
      Logger::getInstance()->error("wx oauth2 response error, errorcode("
        . $obj->errcode . ") and errormsg(" . $obj->errmsg . ")");
      return null;
    }

    if (!isset($obj->openid) || !isset($obj->access_token)) {
      Logger::getInstance()->error("wx oauth2 response error, unknow error, response is " . $res);
      return null;
    }

    $session = new WxSession($obj->access_token, $obj->openid, $obj->scope, $obj->refresh_token, $obj->expires_in);

    return $session;
  }
}