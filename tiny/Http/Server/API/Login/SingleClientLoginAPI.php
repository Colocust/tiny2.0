<?php declare(strict_types=1);


namespace Tiny\Http\Login;


abstract class SingleClientLoginAPI extends LoginAPI {

  protected function isSupportMultiClient(): bool {
    return false;
  }

}