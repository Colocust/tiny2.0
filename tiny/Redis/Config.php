<?php declare(strict_types=1);


namespace Tiny\Redis;


class Config {
  public $host = '127.0.0.1';
  public $port = 0;
  public $timeout = 100;
  public $dbNo = 1;

  public function __construct(string $host, int $port, int $timeout, int $dbNo) {
    $this->host = $host;
    $this->port = $port;
    $this->dbNo = $dbNo;
    $this->timeout = $timeout;
  }
}