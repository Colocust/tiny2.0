<?php

namespace API\ThirdService;

use API\Code;
use API\LoginAPIState;
use API\LoginAPIResponse;
use API\MultiClientLoginAPI;
use Tiny\DelegateManager;
use Tiny\Logger;
use Tiny\Util\Clazz;

class LoginByGuest extends MultiClientLoginAPI {

  protected $uid;

  public function requestClass(): Clazz {
    return Clazz::forClass(LoginByGuestRequest::class);
  }

  protected function login(LoginAPIState &$state): LoginAPIResponse {
    $request = LoginByGuestRequest::fromAPI($this);
    $response = new LoginByGuestResponse();

    /**
     * @var $delegate LoginByGuestDelegate
     */
    $delegate = DelegateManager::getDelegateClassName(
      Clazz::forClass(LoginByGuestDelegate::class));

    if (!$delegate) {
      Logger::getInstance()->error("LoginByGuestDelegate not found delegate");
      return new LoginByGuestResponse(Code::ELSE_ERROR);
    }

    $delegateRequest = new LoginByGuestDelegateRequest();
    $delegateRequest->uuid = $request->uuid;
    $delegateRequest->devinfo = $request->devinfo ?? null;

    $delegateResponse = $delegate::login($delegateRequest);
    $this->uid = $delegateResponse->uid;

    $state = LoginAPIState::success();
    $response->uid = $delegateResponse->uid;
    return $response;
  }


  protected function getUid(): string {
    return $this->uid;
  }
}