<?php


namespace Tiny\MongoDB;


use Config\MongoDBConfig;
use MongoDB\Driver\Manager;

class MongoDB {

  public function __construct(string $collection) {
    $this->collection = $collection;
    $this->address = MongoDBConfig::ADDRESS;
    $this->dbName = MongoDBConfig::DB_NAME;
    $this->user = MongoDBConfig::USER;
    $this->manager = null;
    $this->password = MongoDBConfig::PASSWORD;
  }

  public function getNs(): string {
    return $this->dbName . "." . $this->collection;
  }

  /**
   * 获取连接对象
   * @return \MongoDB\Driver\Manager|null
   */
  public function getManager(): Manager {
    if ($this->manager === null) {
      $this->manager = new Manager($this->address
        , ['password' => $this->password, 'username' => $this->user]);
    }
    return $this->manager;
  }

  public function getDBName(): string {
    return $this->dbName;
  }

  private $dbName;
  private $address;
  private $user;
  private $password;
  private $collection;
  private $manager;
}