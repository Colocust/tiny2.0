<?php declare(strict_types=1);


namespace Tiny\Foundation\Server;


class Response {
  /**
   * @var int
   * @uses \Tiny\Annotation\Uses\Required
   */
  public $code;

  public function __construct(int $code = Code::SUCCESS) {
    $this->code = $code;
  }
}