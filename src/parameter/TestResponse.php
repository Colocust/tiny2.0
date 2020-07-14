<?php declare(strict_types=1);


namespace API;



use Tiny\Http\Response;

class TestResponse extends Response {
  /**
   * @var int
   * @uses \Tiny\Annotation\Uses\Optional
   */
  public $result;
}