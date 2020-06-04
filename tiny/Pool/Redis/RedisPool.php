<?php declare(strict_types=1);


namespace Tiny\Pool\Redis;


use Tiny\Annotation\Reflection\ReflectionClass;
use Tiny\Logger;

class RedisPool {

  private static $hasInit = false;
  public static $pool = [];

  private $configClass = [
    'Tiny\Net\Config',
    'Tiny\Cache\Config',
  ];

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
    foreach ($this->configClass as $configClass) {
      $instance = new ReflectionClass($configClass);
      $class = $instance->getInstance()->newInstanceWithoutConstructor();
      $key = self::generateKey($class::HOST, $class::PORT);

      if (isset(self::$pool[$key])) {
        continue;
      }

      $db = new \Redis();
      $res = $db->pconnect($class::HOST, $class::PORT, $class::TIMEOUT, (string)$class::PORT . '-' . (string)$class::DB);
      if (!$res) {
        Logger::getInstance()->fatal("connect redis("
          . $class::HOST . ":" . $class::PORT . ") error");
        throw new \Exception("connect redis error");
      }

      self::$pool[$key] = $db;
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
    return md5($host . ':' . $port);
  }
}
