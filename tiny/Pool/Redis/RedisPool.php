<?php declare(strict_types=1);


namespace Tiny\Pool\Redis;

use Tiny\Redis;
use Tiny\Redis\Config;

class RedisPool extends Redis {

  public static $pool = [];

  public static function get(string $host, int $port): \Redis {
    $key = self::generateKey($host, $port);

    $redis = @self::$pool[$key];
    if (is_null($redis)) {
      new static(new Config($host, $port));
    }

    unset(self::$pool[$key]);
    return $redis;
  }

  public static function return(string $host, int $port, \Redis $redis) {
    $key = self::generateKey($host, $port);
    self::$pool[$key] = $redis;
  }

  private static function generateKey(string $host, int $port): string {
    return md5($host . ':' . $port);
  }

  private function __construct(Config $config) {
    parent::__construct($config);
    self::$pool[] = $this->db;
  }

  private function __clone() {
  }
}

