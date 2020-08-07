<?php declare(strict_types=1);


namespace Tiny\MySQL;


class MySQL {

    private $host_;
    private $port_;
    private $dbname_;
    private $user_;
    private $password_;

    public function __construct(Config $config) {
        $this->host_ = $config->host_;
        $this->port_ = $config->port_;
        $this->dbname_ = $config->dbname_;
        $this->user_ = $config->user_;
        $this->password_ = $config->password_;
    }

    public function getInstance(): \PDO {
        $dsn = "mysql:host=$this->host_;port=$this->port_;dbname=$this->dbname_";
        $pdo = new \PDO($dsn, $this->user_, $this->password_, array(\PDO::ATTR_PERSISTENT => true));
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->query("set names utf8");
        return $pdo;
    }
}