<?php declare(strict_types=1);


namespace Tiny\Foundation\Server\Logout;


use Tiny\Foundation\Server\JsonAPI;
use Tiny\Foundation\Server\Response;

abstract class LogoutAPI extends JsonAPI {

  protected function run(): Response {

    $this->logout();
    $this->getNet()->close();

    return new LogoutAPIResponse();
  }

  abstract protected function logout(): void;


}