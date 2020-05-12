<?php declare(strict_types=1);


namespace Tiny\Annotation;


use Tiny\Annotation\Type\ArrayType;
use Tiny\Annotation\Type\UserDefinedType;

/**
 *
 * 标注每个成员属性的类型
 *
 * 目前可支持int float string bool userDefinedClass(object)  以及以上几种类型的array
 *
 */
class Type {

  const INT = 'int';
  const STRING = 'string';
  const FLOAT = 'float';
  const BOOL = 'bool';
  const NULL = 'null';

  const PRIMITIVE_TYPE = [
    self::INT, self::STRING, self::FLOAT, self::BOOL, self::NULL
  ];

  public function __construct(string $typeName) {
    $this->typeName_ = $typeName;
  }

  protected $typeName_;


  public static function createType(string $className, string $typeName): ?Type {
    if (!$typeName) {
      return null;
    }
    $isArray = false;

    if (strlen($typeName) >= 2 && $typeName[-2] === '[' && $typeName[-1] === ']') {
      $isArray = true;
      $pos = strpos($typeName, '[');
      $typeName = substr($typeName, 0, $pos);
      if (!$typeName) {
        return null;
      }
    }

    do {
      if (in_array($typeName, self::PRIMITIVE_TYPE)) {
        $type = new PrimitiveType($typeName);
        break;
      }

      $explode = explode('\\', $className);
      array_pop($explode);
      array_push($explode, $typeName);
      $typeName = implode($explode, '\\');
      $type = new UserDefinedType($typeName);
      break;

    } while (false);

    if ($isArray) {
      $type = new ArrayType($typeName, $type);
    }

    return $type;
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

  public function getTypeName(): string {
    return $this->typeName_;
  }
}