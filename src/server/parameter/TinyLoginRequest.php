<?php


namespace API;


class TinyLoginRequest extends LoginAPIRequest {
  /**
   * @var string
   * @uses \Tiny\Util\Required
   */
  public $telephone;
}