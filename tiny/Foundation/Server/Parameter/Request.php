<?php declare(strict_types=1);


namespace Tiny\Foundation\Server;


class Request {
  /**
   * @param API $api
   * @return static
   */
  public static function fromAPI(API $api): Request {
    return $api->getRequest();
  }
}