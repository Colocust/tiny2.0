<?php declare(strict_types=1);


namespace Tiny\Net;

use Tiny\Logger;
use Tiny\Redis;
use Tiny\Redis\Config;
use Tiny\NetValue;

/**
 *
 *
 * 生成方式
 * $netId = 'net_' . $net
 * $ownerId = 'owner_' . $owner
 *
 *
 * 存储方式
 * $netId => $owner (redis String)
 * $ownerId => [$net1,$net2,$net3] (redis Set)
 *
 *
 * 备注
 * owner == uid
 *
 *
 */
class NetDB extends Redis {
    private $net_;
    /**
     * @var $value NetValue
     */
    private $value = null;

    const NET = 'net_';
    const OWNER = 'owner_';

    public function __construct(string $net) {
        $this->net_ = $net;
        parent::__construct(new Config(\config('redis.net.host')
            , \config('redis.net.port')
            , \config('redis.net.timeout')
        ));
        $this->db->select(\config('redis.net.db'));
    }

    public function createNet($owner, int $ttl): void {
        if ($ttl < 0 || $ttl > 30 * 24 * 3600) {
            $ttl = 30 * 24 * 3600;
        }

        $value = new NetValue($owner);

        $netId = self::NET . $this->net_;
        $ownerId = self::OWNER . $owner;

        $this->db->setex($netId, $ttl, json_encode($value));
        $this->db->sAdd($ownerId, $netId);
    }

    public function refreshNet(int $ttl): void {
        if ($this->isValidNet()) {
            $netId = self::NET . $this->net_;
            $this->db->expire($netId, $ttl);
        }
    }

    public function readOwner() {
        if (!$this->isValidNet()) {
            Logger::getInstance()->warn($this->net_ . 'is invalid');
            return null;
        }
        $this->read();
        return $this->value->owner;
    }

    public function isValidNet(): bool {
        $netId = self::NET . $this->net_;
        if ($this->db->exists($netId) === 1 || $this->db->exists($netId) === true) {
            return true;
        }
        return false;
    }

    private function read() {
        if ($this->value !== null) {
            return;
        }
        $netId = self::NET . $this->net_;

        $value = $this->db->get($netId);
        $this->value = json_decode($value);
        return;
    }

    public function del(): void {
        $netId = self::NET . $this->net_;
        $owner = $this->readOwner();
        $this->db->del($netId);
        $this->db->sRem($owner, $netId);
    }

    public static function delAllByOwner(string $owner): void {
        $netDB = new self("");
        $ownerId = self::OWNER . $owner;

        $nets = $netDB->db->sMembers($ownerId);
        foreach ($nets as $net) {
            $netDB->db->del($net);
        }
        $netDB->db->del($ownerId);
    }

    public function getID(): string {
        return $this->net_;
    }
}