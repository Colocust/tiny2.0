<?php declare(strict_types=1);


namespace Tiny\MySQL;


class MySQL {

  private $db_ = null;

  public function __construct(Config $config) {
    $dsn = "mysql:host=$config->host_;dbname=$config->dbname_";
    $this->db_ = new \PDO($dsn, $config->user_, $config->password_, array(\PDO::ATTR_PERSISTENT => true));
    $this->db_->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $this->db_->query("set names utf8");
  }
}