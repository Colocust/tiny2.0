<?php declare(strict_types=1);


namespace API;


use Tiny\Foundation\Server\Login\LoginAPIResponse;
use Tiny\Foundation\Server\Login\MultiClientLoginAPI;
use Tiny\Foundation\Server\Request;

class TestLogin extends MultiClientLoginAPI {

  private $uid;

  public function requestClass(): Request {
    return new TestLoginRequest();
  }

  protected function login(bool &$loginState): LoginAPIResponse {
    $request = TestLoginRequest::fromAPI($this);
    $response = new TestLoginResponse();

    $this->uid = $request->uid;
    $loginState = true;
    return $response;
  }

  protected function getUID() {
    return $this->uid;
  }
}