<?php declare(strict_types=1);


namespace Tiny\Annotation\Type;


use Tiny\Annotation\Type;

class PrimitiveType extends Type {

  public function isBool(): bool {
    return $this->typeName_ === self::BOOL;
  }

  public function isInt(): bool {
    return $this->typeName_ === self::INT;
  }

  public function isNull(): bool {
    return $this->typeName_ === self::NULL;
  }

  public function isFloat(): bool {
    return $this->typeName_ === self::FLOAT;
  }

  public function isString(): bool {
    return $this->typeName_ === self::STRING;
  }
}