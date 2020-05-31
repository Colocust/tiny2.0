<?php declare(strict_types=1);


namespace Tiny\Pool\Redis;


use Swoole\Coroutine;
use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool as SwooleRedisPool;
use Swoole\Runtime;

class RedisPool {

  private static $hasInit = false;
  private static $pool;

  public static function get(string $host, string $port): SwooleRedisPool {
    $key = $host . $port;
    return self::$pool[$key];
  }

  private function __construct() {
    foreach (Config::CLUSTER as $cluster) {
      $key = $cluster['host'] . $cluster['port'];

      self::$pool[$key] = new SwooleRedisPool((new RedisConfig)
        ->withHost($cluster['host'])
        ->withPort($cluster['port'])
        ->withAuth('')
        ->withDbIndex(0)
        ->withTimeout(1)
      );
    }
    self::$hasInit = true;
  }

  public static function init() {
    if (self::$hasInit) return;
    new self();
  }

  private function __clone() {
  }
}