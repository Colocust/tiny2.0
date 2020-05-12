<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Annotation\ClassAnnotation;
use Tiny\Annotation\Type;
use Tiny\Annotation\Uses;
use Tiny\Annotator\Annotator\PropertyAnnotation;
use Tiny\API\HttpStatus;
use Tiny\Exception\ValidateException;

/**
 *
 * 验证器
 *
 * 使用情况的检测
 *
 * 参数类型的检测
 *
 */
class Validate {

  public static function check(object $obj, object $refer): void {
    $toClassName = get_class($refer);
    $classInstance = new ClassAnnotation($toClassName);

    $properties = $classInstance->getProperties();
    foreach ($properties as $property) {
      $propertyInstance = new PropertyAnnotation($toClassName, $property);
      $value = @$obj->{$property};

      //检测使用情况  必填参数且没有值报错
      $uses = $propertyInstance->getUses();

      if (is_null($uses)) {
        $errMsg = "{$property} uses error";
        throw new ValidateException($errMsg, HttpStatus::ARGS_ERROR);
      }
      $checkUses = self::checkUsesIsRight($value, $uses);
      if (!$checkUses) {
        $errMsg = "{$property} is Required，But is null";
        throw new ValidateException($errMsg, HttpStatus::ARGS_ERROR);
      }

      //使用情况通过后只有三种情况
      //必填有值 选填有值
      //选填无值 跳过
      if (is_null($value)) {
        unset($obj->{$property});
        continue;
      }

      //检测类型
      $type = $propertyInstance->getType();
      if (is_null($type)) {
        $errMsg = "{$property} type Error";
        throw new ValidateException($errMsg, HttpStatus::ARGS_ERROR);
      }
      $checkType = self::checkTypeIsRight($value, $type);
      if (!$checkType) {
        $errMsg = $property
          . " type error, except {$type->getTypeName()}, actual "
          . json_encode($value)
          . " get";
        throw new ValidateException($errMsg, HttpStatus::ARGS_ERROR);
      }
    }
  }

  private static function checkUsesIsRight($value, ?Uses $uses): bool {
    if (is_null($value) && $uses->isRequired()) {
      return false;
    }
    return true;
  }

  /**
   * @param $value
   * @param Type $type
   * @return bool
   * @throws ValidateException
   * @throws Exception\ClassNotFoundException
   * @throws Exception\PropertyNotFoundException
   * @throws \ReflectionException
   */
  private static function checkTypeIsRight($value, Type $type): bool {
    if (($type->isString() && is_string($value))
      || ($type->isInt() && is_int($value))
      || ($type->isFloat() && is_float($value))
      || ($type->isBool() && is_bool($value))
      || ($type->isNull() && is_null($value))
    ) {
      return true;
    }

    if ($type->isUserDefinedClass()) {
      if (!is_object($value)) {
        return false;
      }

      $typeName = $type->getTypeName();
      $classInstance = new ClassAnnotation($typeName);
      $refer = $classInstance->getClassInstanceWithoutConstruct();
      self::check($value, $refer);

      return true;
    }

    /**
     * @var $type Type\ArrayType
     */
    if ($type->isArray()) {
      if (!is_array($value)) {
        return false;
      }

      foreach ($value as $item) {
        $checkType = self::checkTypeIsRight($item, $type->getElementType());
        if (!$checkType) {
          return false;
        }
      }
      return true;
    }

    return false;
  }
}