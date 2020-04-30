<?php


namespace Tiny\Net;

use Config\NetDBConfig;
use Tiny\Logger;
use Tiny\NetValue;
use Tiny\Redis;

class NetDB extends Redis {

  private const NET = "net_";
  private const OWNER = "owner_";

  private $netId;
  /**
   * @var $value NetValue
   */
  private $value = null;

  public function __construct(string $netId) {
    parent::__construct(NetDBConfig::HOST, NetDBConfig::PORT, NetDBConfig::TIMEOUT, NetDBConfig::DB);
    $this->netId = $netId;
  }

  public function refreshTTL(int $ttl): void {
    $newKey = self::NET . $this->netId;
    $this->db->expire($newKey, $ttl);
  }

  public function isValidID(): bool {
    $ret = $this->db->exists(self::NET . $this->netId);
    return $ret === true || $ret === 1;
  }

  public function readOwner(): ?string {
    if (!$this->isValidID()) {
      Logger::getInstance()->error("netid($this->netId) is not ValidID");
      return null;
    }
    $this->read();
    return $this->value->owner;
  }

  private function read() {
    if ($this->value !== null) {
      return;
    }

    $netKey = self::NET . $this->netId;
    $value = $this->db->get($netKey);
    $this->value = json_decode($value);

    return;
  }

  public function createNet(string $owner, int $ttl) {
    if ($ttl < 0 || $ttl > 30 * 24 * 3600) {
      $ttl = 30 * 24 * 3600;
    }

    $this->value = new NetValue();
    $this->value->owner = $owner;

    $ownerKey = self::OWNER . $owner;
    $netKey = self::NET . $this->netId;

    $this->db->setex($netKey, $ttl, json_encode($this->value));
    $this->db->sAdd($ownerKey, $netKey);
  }

  public static function delAllByOwner(string $owner) {
    $netDb = new self("");
    $ownerKey = self::OWNER . $owner;

    $nets = $netDb->db->sMembers($ownerKey);

    foreach ($nets as $net) {
      $netDb->db->del($net);
    }
    $netDb->db->del($ownerKey);
  }

  public function del(): void {
    $ownerKey = self::OWNER . $this->readOwner();
    $netKey = self::NET . $this->netId;

    $netDb = new self("");
    $netDb->db->sRem($ownerKey, $netKey);
    $netDb->db->del($netKey);
  }

  public function getID(): string {
    return $this->netId;
  }
}