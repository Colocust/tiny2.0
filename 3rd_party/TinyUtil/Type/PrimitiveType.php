<?php

namespace Tiny\Util\Type;

use Tiny\Util\Type;

class PrimitiveType extends Type {
  public function isBool(): bool {
    return $this->type_ === self::_bool;
  }

  public function isInt(): bool {
    return $this->type_ === self::_int;
  }

  public function isNull(): bool {
    return $this->type_ === self::_null;
  }

  public function isFloat(): bool {
    return $this->type_ === self::_float;
  }

  public function isString(): bool {
    return $this->type_ === self::_string;
  }
}