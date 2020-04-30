<?php


namespace API\ThirdService;


interface LoginByGuestDelegate {
  public static function login(LoginByGuestDelegateRequest $request): LoginByGuestDelegateResponse;
}