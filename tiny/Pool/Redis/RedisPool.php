<?php declare(strict_types=1);


namespace Tiny\Pool\Redis;


use Tiny\Annotation\Reflection\ReflectionClass;
use Tiny\Logger;
use Tiny\Redis;

class RedisPool {

  private static $hasInit = false;
  public static $pool = [];

  private $configClass = [

  ];

  public static function get(string $host, int $port, int $dbNo): ?\Redis {
    $key = self::generateKey($host, $port, $dbNo);

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
      $key = self::generateKey($class::HOST, $class::PORT, $class::DB);
      if (isset(self::$pool[$key])) {
        continue;
      }

      $config = new Redis\Config($class::HOST, $class::PORT, $class::TIMEOUT, $class::DB);
      try {
        $redis = new Redis($config);
        self::$pool[$key] = $redis->db;
      } catch (\Exception $e) {
        Logger::getInstance()->fatal('', $e);
      }
    }


    self::$hasInit = true;
  }

  public static function init() {
    if (self::$hasInit) return;
    new self();
  }

  private function __clone() {
  }

  public static function return(string $host, int $port, int $dbNo, \Redis $redis) {
    $key = self::generateKey($host, $port, $dbNo);
    self::$pool[$key] = $redis;
  }

  private static function generateKey(string $host, int $port, int $db): string {
    return md5($host . ':' . $port . ':' . $db);
  }
}
