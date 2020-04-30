<?php


namespace API\ThirdService;


use API\LoginAPIResponse;

class LoginByGuestResponse extends LoginAPIResponse {
  /**
   * @var string
   */
  public $errMsg;
  /**
   * @var string
   */
  public $uid;
}