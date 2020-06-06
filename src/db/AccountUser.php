<?php declare(strict_types=1);


namespace TinyDB;


class AccountUser extends DB {

  public function getCollection(): string {
    return 'AccountUser';
  }
}