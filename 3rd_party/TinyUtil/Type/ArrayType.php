<?php


namespace Tiny\Util\Type;


use Tiny\Util\Type;

class ArrayType extends Type {
  public function isArray(): bool {
    return true;
  }

  public function __construct(string $type = "", ?Type $rootType = null) {
    parent::__construct($type);
    $this->rootType_ = $rootType;
  }

  public function getRootType(): Type {
    if ($this->rootType_ === null) {
      return new Type();
    }

    return $this->rootType_;
  }

  public function getElementType(): Type {
    if ($this->type_ === self::_array) {
      return new Type();
    }

    return Type::createTypeFromRule(substr($this->type_, 0, -2));
  }

  public function getName(): string {
    return $this->type_ . '[]';
  }

  private $rootType_;
}