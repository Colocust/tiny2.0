<?php


namespace Tiny\Util;


class Uses {
  const REQUIRED = '@Required';
  const OPTIONAL = '@Optional';

  public function __construct(bool $uses) {
    $this->uses = $uses;
  }

  public function getValue(): string {
    if ($this->uses) {
      return self::REQUIRED;
    }
    return self::OPTIONAL;
  }

  private $uses;
}