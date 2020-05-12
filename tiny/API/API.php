<?php declare(strict_types=1);

namespace Tiny;


use Tiny\API\Request;
use Tiny\API\Response;

abstract class API {

  public function process(Request $request, Response $response) {
    if ($this->parseRequestParameter($request, $response)) {
      $this->go($request, $response);
      $this->parseResponseParameter($request, $response);
    }
  }

  abstract protected function go(Request $request, Response $response);

  abstract protected function parseRequestParameter(Request $request, Response $response): bool;

  abstract protected function parseResponseParameter(Request $request, Response $response): void;

}