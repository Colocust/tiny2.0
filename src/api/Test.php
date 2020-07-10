<?php declare(strict_types=1);


namespace API;


use Enum\ResultEnum;
use Tiny\Foundation\Server\JsonAPI;
use Tiny\Foundation\Server\Request;
use Tiny\Foundation\Server\Response;


class Test extends JsonAPI {

  public $map = [];

  public function requestClass(): Request {
    return new TestRequest();
  }

  protected function run(): Response {
    $request = TestRequest::fromAPI($this);
    $response = new TestResponse();

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}