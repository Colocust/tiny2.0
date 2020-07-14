<?php declare(strict_types=1);


namespace API;


use Enum\ResultEnum;
use Tiny\Http\JsonAPI;
use Tiny\Http\Request;
use Tiny\Http\Response;


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