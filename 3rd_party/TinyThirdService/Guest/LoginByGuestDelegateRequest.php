<?php


namespace API\ThirdService;


class LoginByGuestDelegateRequest {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $uuid;
  /**
   * @var string
   */
  public $devinfo;
}