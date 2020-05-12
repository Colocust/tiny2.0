<?php declare(strict_types=1);


namespace API;


use Tiny\Foundation\Server\JsonAPI;
use Tiny\Foundation\Server\Request;
use Tiny\Foundation\Server\Response;
use Tiny\Helper\Time;
use Tiny\Logger;


class Test extends JsonAPI {

  protected function requestClass(): Request {
    return new TestRequest();
  }

  protected function run(): Response {
    $request = TestRequest::fromAPI($this);
    $response = new TestResponse();

//    go(function () {
//      sleep(5);
//      echo Time::getCurrentMillSecondToString() . 'co' . PHP_EOL;
//    });

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}