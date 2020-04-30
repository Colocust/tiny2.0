<?php


namespace API;


use Tiny\Logger;
use Tiny\Net;
use Tiny\Util\Clazz;

abstract class LogoutAPI extends API {

  public function requestClass(): Clazz {
    return Clazz::forClass(LogoutAPIRequest::class);
  }

  protected function doRun(): Response {
    $this->logout();
    $this->getNet()->close();

    return new LogoutAPIResponse();
  }

  abstract protected function logout();
}