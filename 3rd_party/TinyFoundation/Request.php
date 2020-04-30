<?php


namespace API;


class Request {
  /**
   * @param API $api
   * @return static
   */
  public static function fromAPI(API $api): Request {
    return $api->getRequest();
  }

}