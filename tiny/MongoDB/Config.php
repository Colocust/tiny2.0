<?php


namespace Tiny\MongoDB;


class Config {
  public function __construct(string $uri,
                              string $user,
                              string $password,
                              string $dbname,
                              string $collection) {
    $this->uri_ = $uri;
    $this->user_ = $user;
    $this->password_ = $password;
    $this->dbname_ = $dbname;
    $this->collection_ = $collection;
  }

  public $uri_;
  public $user_;
  public $password_;
  public $dbname_;
  public $collection_;
}