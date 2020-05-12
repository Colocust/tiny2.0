<?php declare(strict_types=1);


namespace Tiny\Foundation\Server\Login;


abstract class SingleClientLoginAPI extends LoginAPI {

  protected function isSupportMultiClient(): bool {
    return false;
  }

}