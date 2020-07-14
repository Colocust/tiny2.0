<?php declare(strict_types=1);


namespace Tiny\Http\Logout;



use Tiny\Http\JsonAPI;
use Tiny\Http\Response;

abstract class LogoutAPI extends JsonAPI {

  protected function run(): Response {

    $this->logout();
    $this->getNet()->close();

    return new LogoutAPIResponse();
  }

  abstract protected function logout(): void;


}