<?php


namespace Tiny\Util;


class Clazz {
  private function __construct(string $name) {
    $this->name_ = $name;
  }

  static public function forClass(string $className): Clazz {
    return new static($className);
  }

  public function getName(): string {
    return $this->name_;
  }

  public function getShortName(): string {
    $pos = strrpos($this->name_, '\\');
    if ($pos === false) {
      return $this->getName();
    }

    return substr($this->name_, $pos + 1);
  }

  public function getNamespace(): string {
    $pos = strrpos($this->name_, '\\');
    if ($pos === false) {
      return "";
    }

    return substr($this->name_, 0, $pos);
  }

  function __toString(): string {
    return $this->name_;
  }


  private $name_;
}