<?php


namespace API;


class LoginAPIState {
  private $ok_ = false;

  private function __construct(bool $ok) {
    $this->ok_ = $ok;
  }

  public function isSuccess(): bool {
    return $this->ok_ == true;
  }

  public static function success(): self {
    return new LoginAPIState(true);
  }

  public static function failed(): self {
    return new LoginAPIState(false);
  }
}