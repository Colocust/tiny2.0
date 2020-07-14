<?php declare(strict_types=1);


namespace API;



use Tiny\Http\Login\LoginAPIResponse;
use Tiny\Http\Login\MultiClientLoginAPI;
use Tiny\Http\Request;

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