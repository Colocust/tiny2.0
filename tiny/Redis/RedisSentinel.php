<?php declare(strict_types=1);

namespace Tiny;


class RedisSentinel {
    /**
     * @var $sentinel_ \Redis
     */
    private $sentinel_ = null;

    public function getMaster(): \Redis {
        $commandRet = $this->sentinel_->rawCommand('SENTINEL'
            , 'master'
            , config('redis.sentinel.masterName'));

        $ret = $this->parseCommandRet($commandRet);
        $redis = new \Redis();
        $redis->pconnect($ret['ip'], (int)$ret['port'], 100);

        return $redis;
    }

    public function getSlave(): \Redis {
        $commandRet = $this->sentinel_->rawCommand('SENTINEL'
            , 'slaves'
            , config('redis.sentinel.masterName'));

        $ret = $this->parseCommandRet($commandRet);
        $length = count($ret);
        $index = rand(0, $length - 1);

        $redis = new \Redis();
        $redis->pconnect($ret[$index]['ip'], (int)$ret[$index]['port'], 100);

        return $redis;
    }

    public function __construct() {
        $uri = config('redis.sentinel.uri');

        foreach ($uri as $sentinel) {
            $redis = new \Redis();
            try {
                $redis->pconnect($sentinel['host'], $sentinel['port']);
                $this->sentinel_ = $redis;
            } catch (\RedisException $e) {
                Logger::getInstance()->error($sentinel['host'] . ':' . $sentinel['port'] . ' can not connect ', $e);
            }
        }

        if (is_null($this->sentinel_)) {
            throw new \Exception('all sentinels cannot be connected');
        }
    }

    private function parseCommandRet(array $commandRet): array {
        $result = array();
        $count = count($commandRet);
        for ($i = 0; $i < $count;) {
            $record = $commandRet[$i];
            if (is_array($record)) {
                $result[] = $this->parseCommandRet($record);
                $i++;
            } else {
                $result[$record] = $commandRet[$i + 1];
                $i += 2;
            }
        }
        return $result;
    }

}