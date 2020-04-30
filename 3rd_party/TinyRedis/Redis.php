<?php


namespace Tiny;

class Redis {

  /**
   * Redis constructor.
   * @param string $host
   * @param int $port
   * @param int $timeout
   * @param int $dbNo
   * @throws \Exception
   */
  public function __construct(string $host, int $port, int $timeout, int $dbNo) {
    $this->db = new \Redis();

    $res = $this->db->pconnect($host, $port, $timeout, (string)$port . '-' . (string)$dbNo);
    if (!$res) {
      Logger::getInstance()->fatal("connect redis("
        . $host . ":" . $port . ") error");
      throw new \Exception("connect redis error");
    }
    $res = $this->db->select($dbNo);
    if (!$res) {
      Logger::getInstance()->fatal("select redis("
        . $host . ":" . $port . ") to " . $dbNo . " error");
      throw new \Exception("select redis error");
    }
  }

  protected $db;
}