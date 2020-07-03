<?php declare(strict_types=1);


namespace Tiny\Redis;


class Config {
  public $host = '127.0.0.1';
  public $port = 0;
  public $timeout = 100;

  public function __construct(string $host, int $port, int $timeout = 0) {
    $this->host = $host;
    $this->port = $port;
    $this->timeout = $timeout;
  }
}