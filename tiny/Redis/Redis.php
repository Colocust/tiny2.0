<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Redis\Config;

class Redis {

  public function __construct(Config $config) {
    $this->db = new \Redis();
    $res = $this->db->pconnect($config->host
      , $config->port
      , $config->timeout
      , (string)$config->port . '-' . (string)$config->dbNo);
    if (!$res) {
      Logger::getInstance()->fatal("connect redis("
        . $config->host . ":" . $config->port . ") error");
      throw new \Exception("connect redis error");
    }
    $res = $this->db->select($config->dbNo);
    if (!$res) {
      Logger::getInstance()->fatal("select redis("
        . $config->host . ":" . $config->port . ") to " . $config->dbNo . " error");
      throw new \Exception("select redis error");
    }
  }

  public $db;

}