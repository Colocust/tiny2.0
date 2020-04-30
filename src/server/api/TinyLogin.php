<?php


namespace API;


use Tiny\Util\Clazz;

class TinyLogin extends MultiClientLoginAPI {

  public function requestClass(): Clazz {
    return Clazz::forClass(TinyLoginRequest::class);
  }

  protected function login(LoginAPIState &$state): LoginAPIResponse {
    $request = TinyLoginRequest::fromAPI($this);
    $response = new TinyLoginResponse();

    $state = LoginAPIState::success();

    $this->uid = $request->telephone;
    $response->uid = $request->telephone;
    return $response;
  }

  protected $uid;

  protected function getUid(): string {
    return $this->uid;
  }
}
