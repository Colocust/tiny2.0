<?php

namespace DB;


use Tiny\MongoDB\Model;
use Tiny\Util\Clazz;

class AccountUser extends Model {

  protected function info(): Clazz {
    return Clazz::forClass(AccountUserInfo::class);
  }

  protected function table(): string {
    return 'user';
  }

  public function addd() {
    $this->where('','','')->find();
  }


  protected function collection(): string {
    return 'AccountUser';
  }
}