<?php


namespace API;


class ErrorResponse extends Response {
  /**
   * @var string
   * @uses required
   */
  public $errMsg;

  public function __construct(int $code = Code::ELSE_ERROR, string $errMsg = "运行错误") {
    parent::__construct($code);
    $this->errMsg = $errMsg;
  }
}