<?php


namespace API;


use Tiny\Logger;
use Tiny\Net;
use Tiny\Util\Clazz;

abstract class LoginAPI extends API {

  protected function needToken(): bool {
    return false;
  }

  abstract protected function login(LoginAPIState &$state): LoginAPIResponse;

  abstract protected function getUid(): string;

  abstract protected function isSupportMultiClient(): bool;

  /**
   * @return Response
   * @throws \Exception
   */
  protected function doRun(): Response {
    $state = LoginAPIState::failed();
    $response = $this->login($state);

    if (!$state->isSuccess() || $response->code != Code::SUCCESS) {
      $response->token = "";
      Logger::getInstance()->error("LoginAPIState is failed.");
      return $response;
    }

    $uid = $this->getUid();
    $net = Net::createNetByUid($uid, $this->isSupportMultiClient());

    $response->token = $net->getID();
    return $response;
  }
}