<?php declare(strict_types=1);


namespace Tiny\Pool\Redis;


class RedisPool {

  private static $hasInit = false;
  private static $pool = [];

  public static function get(string $host, int $port): ?\Redis {
    $key = self::generateKey($host, $port);

    $redis = @self::$pool[$key];
    if (is_null($redis)) {
      return null;
    }

    unset(self::$pool[$key]);
    return $redis;
  }

  private function __construct() {
    foreach (Config::CLUSTER as $cluster) {
      $key = self::generateKey($cluster['host'], $cluster['port']);
      $redis = new \Redis();
      $redis->connect($cluster['host'], $cluster['port']);

      self::$pool[$key] = $redis;
    }
    self::$hasInit = true;
  }

  public static function init() {
    if (self::$hasInit) return;
    new self();
  }

  private function __clone() {
  }

  public static function return(string $host, int $port, \Redis $redis) {
    $key = self::generateKey($host, $port);
    self::$pool[$key] = $redis;
  }

  private static function generateKey(string $host, int $port): string {
    return $host . ':' . $port;
  }
}

