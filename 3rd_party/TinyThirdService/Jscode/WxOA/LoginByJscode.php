<?php


namespace API\ThirdService\WxOA;

use API\Code;
use API\LoginAPI;
use API\LoginAPIResponse;
use API\LoginAPIState;
use API\SingleClientLoginAPI;
use Tiny\DelegateManager;
use Tiny\Logger;
use Tiny\Util\Clazz;

class LoginByJscode extends SingleClientLoginAPI {

  public function requestClass(): Clazz {
    return Clazz::forClass(LoginByJscodeRequest::class);
  }

  protected function login(LoginAPIState &$state): LoginAPIResponse {
    $request = LoginByJscodeRequest::fromAPI($this);
    $response = new LoginByJscodeResponse();

    /**
     * @var $delegate LoginByJscodeDelegate
     */
    $delegate = DelegateManager::getDelegateClassName(
      Clazz::forClass(LoginByJscodeDelegate::class));

    if (!$delegate) {
      Logger::getInstance()->error("LoginByJscode not found delegate");
      return new LoginByJscodeResponse(Code::ELSE_ERROR);
    }

    $session = WxHelper::oauth2($request->jscode, $delegate::getAppId(), $delegate::getAppSecret());

    if (!$session) {
      Logger::getInstance()->error("LoginByJscode jscode2session fail");
      return new LoginByJscodeResponse(Code::ELSE_ERROR);
    }

    $delegateRequest = new LoginByJscodeDelegateRequest();
    $delegateRequest->openid = $session->openid;
    $delegateRequest->access_token = $session->access_token;

    $delegateResponse = $delegate::login($delegateRequest);
    $this->uid = $delegateResponse->uid;
    $state = $delegateResponse->state;
    if (!$state->isSuccess()) {
      Logger::getInstance()->info("openid($session->openid)登录失败，有客户端尝试其他登录");
      $response = new LoginByJscodeResponse(Code::NOT_ACCEPTABLE);
      $response->errMsg = $delegateResponse->errMsg;
      return $response;
    }
    return $response;
  }

  protected $uid;

  protected function getUid(): string {
    return $this->uid;
  }
}