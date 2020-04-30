<?php


namespace API;


class Response {
  /**
   * @var int
   * @uses \Tiny\Util\Required
   */
  public $code;

  public function __construct(int $code = Code::SUCCESS) {
    $this->code = $code;
  }
}