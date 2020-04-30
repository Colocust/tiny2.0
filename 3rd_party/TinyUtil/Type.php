<?php


namespace Tiny\Util;

use Tiny\Util\Type\ArrayType;
use Tiny\Util\Type\PrimitiveType;
use Tiny\Util\Type\UserDefinedType;

class Type {

  protected const _int = 'int';
  protected const _bool = 'bool';
  protected const _string = 'string';
  protected const _float = 'float';
  protected const _null = 'null';
  protected const _array = 'array';

  protected const primitive = [
    self::_int, self::_bool, self::_string, self::_float, self::_null
  ];


  protected $type_;

  protected function __construct(string $type = "") {
    $this->type_ = $type;
  }

  public function getName(): string {
    return $this->type_;
  }

  public static function createTypeFromRule(string $type): Type {
    $array = false;
    if ($type == "") {
      return new Type();
    }
    if (strlen($type) >= 2 && $type[-2] === '[' && $type[-1] === ']') {
      $pos = strpos($type, '[');
      $type = substr($type, 0, $pos);
      $array = true;
    }

    do {
      if (in_array($type, self::primitive)) {
        $root = new PrimitiveType($type);
        break;
      }

      $root = new UserDefinedType($type);
      break;

    } while (false);

    if ($array) {
      $root = new ArrayType($type, $root);
    }
    return $root;
  }

  public function isArray(): bool {
    return false;
  }

  public function isBool(): bool {
    return false;
  }

  public function isInt(): bool {
    return false;
  }

  public function isNull(): bool {
    return false;
  }

  public function isFloat(): bool {
    return false;
  }

  public function isString(): bool {
    return false;
  }

  public function isUserDefinedClass(): bool {
    return false;
  }

}