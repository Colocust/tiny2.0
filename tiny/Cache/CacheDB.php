<?php declare(strict_types=1);


namespace Tiny\Cache;


use Tiny\Redis;
use Tiny\Redis\Config;


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

        parent::__construct(new Config(\config('redis.net.host')
            , \config('redis.net.port')
            , \config('redis.net.timeout')
        ));
        $this->db->select(\config('redis.net.db'));
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