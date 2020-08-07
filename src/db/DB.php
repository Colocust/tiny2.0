<?php declare(strict_types=1);


namespace TinyDB;

use Tiny\MongoDB\Config;
use Tiny\MongoDB\Model;

abstract class DB extends Model {
    public function __construct() {
        $config = new Config(\TinyDB\Config::URI
            , \TinyDB\Config::USER
            , \TinyDB\Config::PASSWORD
            , \TinyDB\Config::DBNAME,
            $this->getCollection());
        parent::__construct($config);
    }
}