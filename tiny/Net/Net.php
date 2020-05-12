<?php declare(strict_types=1);


namespace Tiny;

use Tiny\Net\NetDB;

class Net {
  private $db;

  public function __construct(string $net, ?NetDB $netDB) {
    $this->db = $netDB;
    if ($this->db == null) {
      $this->db = new NetDB($net);
    }
  }

  final public static function readById(string $netId): ?self {
    $netDb = new NetDB($netId);
    if (!$netDb->isValidNet()) {
      return null;
    }

    if (!$netDb->readOwner()) {
      return null;
    }

    $net = new self($netId, $netDb);
    $net->refreshWhenUsed(60 * 24 * 30);
    return $net;
  }

  public function refreshWhenUsed(int $ttl) {
    $this->db->refreshNet($ttl);
  }

  final static public function createByOwner($owner, int $ttl, bool $isSupportMultiClient): self {
    $netId = self::newId($owner);
    $netDb = new NetDB($netId);
    if ($isSupportMultiClient) {
      NetDB::delAllByOwner($owner);
    }
    $netDb->createNet($owner, $ttl);
    return new self($netId, $netDb);
  }

  public function getID(): string {
    return $this->db->getID();
  }

  public function getUID() {
    return $this->db->readOwner();
  }

  public static function newId($owner) {
    return md5($owner . mt_rand(10, 1000) . mt_rand(1000, 10000));
  }

  public static function closeAllByOwner($owner): void {
    NetDB::delAllByOwner($owner);
  }

  public function close(): void {
    $this->db->del();
  }
}