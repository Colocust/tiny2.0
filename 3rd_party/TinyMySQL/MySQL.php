<?php

namespace Tiny\MySQL;


use Config\MySQLConfig;

class MySQL {

  private $table;
  private $host;
  private $port;
  private $user;
  private $password;
  private $database;

  public function __construct(string $table) {
    $this->table = $table;
    $this->host = MySQLConfig::HOST;
    $this->port = MySQLConfig::PORT;
    $this->user = MySQLConfig::USERNAME;
    $this->password = MySQLConfig::PASSWORD;
    $this->database = MySQLConfig::DATABASE;
  }

  private $conn_ = null;

  public function getConnect(): \mysqli {
    if ($this->conn_ === null) {
      $this->conn_ = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port);
      if (!$this->conn_) {
        throw new \Exception("尝试连接host为{$this->host},port为{$this->port},user为{$this->user},password为{$this->password},database为{$this->database}的数据库失败");
      }
      $this->conn_->query("set names utf8");
      $this->conn_->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
    }
    return $this->conn_;
  }

}