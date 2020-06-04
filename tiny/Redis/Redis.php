<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Pool\Redis\RedisPool;
use Tiny\Redis\Config;

class Redis {
  /**
   * @var $config Config
   */
  private $config;

  protected function __construct(Config $config) {
    $this->config = $config;
    //此段代码需要优化
    //当前没有连接池实例时需要适当延迟再次获取
    $this->db = RedisPool::get($config->host, $config->port);
    $this->db->select($config->dbNo);
  }

  public function __destruct() {
    RedisPool::return($this->config->host, $this->config->port, $this->db);
  }

  protected $db;

}