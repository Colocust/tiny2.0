<?php


namespace DB;


use Tiny\MongoDB\Info;

class AccountUserInfo extends Info {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $name;
}