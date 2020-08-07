<?php declare(strict_types=1);


namespace Tiny\Cache;


use Tiny\Redis;
use Tiny\Redis\Config;
use Tiny\Cache\Config as CacheConfig;


/**
 *
 * 生成方式
 * $cacheId => 'cache_' . $key
 *
 * 存储方式
 * $cacheId => $value (redis String)
 *
 */
class CacheDB extends Redis {
    const CACHE = 'cache_';

    private $id;

    public function __construct(string $key) {
        $this->id = self::CACHE . $key;

        parent::__construct(new Config(CacheConfig::HOST
            , CacheConfig::PORT
            , CacheConfig::TIMEOUT
        ));
        $this->db->select(CacheConfig::DB);
    }

    public function setex(int $ttl, string $value): void {
        $this->db->setex($this->id, $ttl, $value);
    }

    public function read(): string {
        return $this->db->get($this->id);
    }

    public function exists(): bool {
        return $this->db->exists($this->id);
    }

    public function del(): void {
        $this->db->del($this->id);
    }

}