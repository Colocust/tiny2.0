<?php declare(strict_types=1);


namespace Tiny\MySQL;


class Model {
  /**
   * @var \PDO
   */
  protected $instance;

  public function __construct(Config $config) {
    $mysql = new MySQL($config);
    $this->instance = $mysql->getInstance();
  }
}
