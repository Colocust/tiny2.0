<?php

namespace API;


use Tiny\Util\Clazz;

class Test extends API {

  public function requestClass(): Clazz {
    return Clazz::forClass(TestRequest::class);
  }


  protected function doRun(): Response {
    $request = TestRequest::fromAPI($this);
    $response = new TestResponse();

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}







