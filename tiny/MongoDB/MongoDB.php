<?php declare(strict_types=1);


namespace Tiny\MongoDB;


use MongoDB\Driver\Manager;

class MongoDB {
  private $uri_;
  private $user_;
  private $password_;
  private $dbname_;
  private $collection_;

  private $manager_;

  public function __construct(Config $config) {
  }

  public function getNs(): string {
    return $this->dbname_ . "." . $this->collection_;
  }

  /**
   * 获取连接对象
   * @return \MongoDB\Driver\Manager|null
   */
  public function getManager(): Manager {
    if ($this->manager_ === null) {
      $this->manager_ = new Manager($this->uri_
        , ['password' => $this->password_, 'username' => $this->user_]);
    }
    return $this->manager_;
  }

  public function getDBName(): string {
    return $this->dbname_;
  }
}