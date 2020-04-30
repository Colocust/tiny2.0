<?php


namespace API\ThirdService;


use API\LoginAPIRequest;

class LoginByGuestRequest extends LoginAPIRequest {
  /**
   * @var int[]
   */
  public $uuid;
  /**
   * @var string
   */
  public $devinfo;
}