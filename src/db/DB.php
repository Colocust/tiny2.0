<?php declare(strict_types=1);


namespace TinyDB;

use Tiny\MongoDB\Config;
use Tiny\MongoDB\Model;

abstract class DB extends Model {
    public function __construct() {
        $config = new Config(config('mongodb.db.uri')
            , config('mongodb.db.user')
            , config('mongodb.db.password')
            , config('mongodb.db.dbname'),
            $this->getCollection());
        parent::__construct($config);
    }
}