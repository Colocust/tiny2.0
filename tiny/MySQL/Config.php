<?php declare(strict_types=1);


namespace Tiny\MySQL;


class Config {

    public function __construct(string $host,
                                string $port,
                                string $dbname,
                                string $user,
                                string $password) {
        $this->host_ = $host;
        $this->port_ = $port;
        $this->dbname_ = $dbname;
        $this->user_ = $user;
        $this->password_ = $password;
    }

    public $host_;
    public $port_;
    public $dbname_;
    public $user_;
    public $password_;
}