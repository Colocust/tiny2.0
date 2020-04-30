<?php


namespace Tiny;


class Response {
  function __construct() {
    $this->httpStatus = HttpStatus::SUC;
  }

  public $httpStatusMsg;
  public $data;
  public $httpStatus;
  public $httpHeaders = [
    'Access-Control-Allow-Origin' => '*',
    'Access-Control-Allow-Headers' => 'Referer,Origin, Content-Type, Cookie, Accept,User-Agent',
    'Access-Control-Allow-Methods' => 'POST',
    'Access-Control-Allow-Credentials' => 'true'
  ];
}