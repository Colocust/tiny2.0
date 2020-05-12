<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Cache\CacheDB;

class Cache {
  /**
   * @var $db CacheDB
   */
  private $db;

  public function __construct(string $key, ?CacheDB $cacheDB = null) {
    $this->db = $cacheDB;
    if ($this->db == null) {
      $this->db = new CacheDB($key);
    }
  }

  final public static function createByKey(string $key, int $ttl, string $value): Cache {
    $cacheDB = new CacheDB($key);
    $cacheDB->setex($ttl, $value);

    return new self($key, $cacheDB);
  }

  public function readByKey(string $key): ?string {
    if ($this->db->exists()) {
      return $this->db->read();
    }
    return null;
  }

  public function delCache(): void {
    $this->db->del();
  }

}