<?php declare(strict_types=1);


namespace API;


use Tiny\Foundation\Server\Login\LoginAPIResponse;

class TestLoginResponse extends LoginAPIResponse {
  /**
   * @var int
   */
  public $result;
}