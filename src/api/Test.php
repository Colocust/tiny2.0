<?php declare(strict_types=1);


namespace API;


use Tiny\Foundation\Server\JsonAPI;
use Tiny\Foundation\Server\Request;
use Tiny\Foundation\Server\Response;
use Tiny\Logger;


class Test extends JsonAPI {

  public $map = [];

  protected function requestClass(): Request {
    return new TestRequest();
  }

  protected function run(): Response {
    $request = TestRequest::fromAPI($this);
    $response = new TestResponse();

    $this->map[$request->id] = 1;
    Logger::getInstance()->info(json_encode($this->map));
    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}