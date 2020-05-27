<?php declare(strict_types=1);


namespace Tiny\MongoDB;


class Collection {

  private $db_;

  private static $map_ = [];

  private function __construct(Config $config) {
    $this->db_ = new MongoDB($config);
  }

  public static function build(Config $config): Collection {
    $key = $config->uri_ . $config->dbname_ . $config->collection_;
    $collection = @self::$map_[$key];

    if (is_null($collection)) {
      $collection = new Collection($config);
      self::$map_[$key] = $collection;
    }

    return $collection;
  }
}