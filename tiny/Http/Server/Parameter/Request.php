<?php declare(strict_types=1);


namespace Tiny\Http;


class Request {
  /**
   * @param API $api
   * @return static
   */
  public static function fromAPI(API $api): Request {
    return $api->getRequest();
  }
}