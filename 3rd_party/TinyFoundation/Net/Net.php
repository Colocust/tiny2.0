<?php

namespace Tiny;


use Tiny\Net\NetDB;

class Net {

  protected $db_;

  /**
   * Net constructor.
   * @param string $id
   * @param NetDB|null $db
   * @throws \Exception
   */
  public function __construct(string $id, ?NetDB $db = null) {
    $this->db_ = $db;
    if ($this->db_ === null) {
      $this->db_ = new NetDB($id);
    }
  }

  /**
   * @param string $netId
   * @return Net|null
   * @throws \Exception
   */
  final public static function readNetById(string $netId): ?Net {
    $db = new NetDB($netId);

    if (!$db->isValidID()) {
      return null;
    }
    if (!$db->readOwner()) {
      return null;
    }

    $net = new Net($netId, $db);
    $net->refreshTTLWhenUsed();
    return $net;
  }

  /**
   * @param string $uid
   * @param bool $isSupportMultiClient
   * @param int $ttl
   * @return Net
   * @throws \Exception
   */
  final public static function createNetByUid(string $uid,
                                              bool $isSupportMultiClient,
                                              int $ttl = 30 * 24 * 3600): Net {
    $netId = Net::newId($uid);
    $db = new NetDB($netId);

    //如果不支持多端登录,需要通过uid删除所有网络
    if (!$isSupportMultiClient) {
      NetDB::delAllByOwner($uid);
    }
    $db->createNet($uid, $ttl);

    return new self($netId, $db);
  }

  public function getUid(): string {
    return $this->db_->readOwner();
  }

  public function getID(): string {
    return $this->db_->getID();
  }

  public function refreshTTLWhenUsed(): void {
    $this->db_->refreshTTL($this->TTL());
  }

  protected function TTL(): int {
    return 30 * 24 * 3600;
  }

  public static function newId(string $owner): string {
    return md5($owner . mt_rand(10, 1000) . mt_rand(1000, 10000));
  }

  public static function closeAllByOwner(string $owner): void {
    NetDB::delAllByOwner($owner);
  }

  public function close(): void {
    $this->db_->del();
  }
}