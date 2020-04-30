<?php

namespace Tiny;

ini_set("display_errors", "on");

require_once '/home/module/Sms/api_sdk/vendor/autoload.php';

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Config\SmsConfig;

// 加载区域结点配置
Config::load();

class Sms {

  static $acsClient = null;

  /**
   * @return DefaultAcsClient
   */
  public static function getAcsClient() {
    $product = "Dysmsapi";
    $domain = "dysmsapi.aliyuncs.com";
    $region = "cn-hangzhou";
    $endPointName = "cn-hangzhou";
    if (static::$acsClient == null) {
      $profile = DefaultProfile::getProfile($region, SmsConfig::ACCESS_KEY_ID, SmsConfig::ACCESS_KEY_SECRET);
      DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);
      static::$acsClient = new DefaultAcsClient($profile);
    }
    return static::$acsClient;
  }


  public function sendSms(string $telephone, int $captcha) {
    $request = new SendSmsRequest();
    $request->setPhoneNumbers($telephone);
    $request->setSignName(SmsConfig::SIGN_NAME);
    $request->setTemplateCode(SmsConfig::TEMPLATE_CODE);
    $request->setTemplateParam(json_encode(array(
      "code" => $captcha,
    ), JSON_UNESCAPED_UNICODE));
    return static::getAcsClient()->getAcsResponse($request);
  }
}