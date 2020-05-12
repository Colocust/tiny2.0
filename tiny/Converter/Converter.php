<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Annotation\Reflection\ReflectionClass;
use Tiny\Annotation\Reflection\ReflectionProperty;
use Tiny\Annotation\Type;
use Tiny\Annotation\Uses;
use Tiny\API\HttpStatus;
use Tiny\Exception\ConverterException;


class Converter {

  public function convert(object $from, object &$object): void {
    $class = new ReflectionClass(get_class($object));
    $reflectionProperties = $class->getInstance()->getProperties();
    foreach ($reflectionProperties as $reflectionProperty) {
      $property = new ReflectionProperty($reflectionProperty->getDeclaringClass()->getName(), $reflectionProperty->getName());

      $uses = $property->getUses();
      if (is_null($uses)) {
        throw new ConverterException("{$reflectionProperty->getName()} uses error"
          , HttpStatus::ARGS_ERROR);
      }
      if (!$this->checkUsesIsRight(@$from->{$reflectionProperty->getName()}, $uses)) {
        throw new ConverterException("{$reflectionProperty->getName()} is Required，But is null"
          , HttpStatus::ARGS_ERROR);
      }

      $type = $property->getType();
      if (is_null($type)) {
        throw new ConverterException("{$reflectionProperty->getName()} type error"
          , HttpStatus::ARGS_ERROR);
      }

      $value = @$from->{$reflectionProperty->getName()};
      if (is_null($value)) {
        continue;
      }

      if (!$this->checkTypeIsRight($value, $type)) {
        throw new ConverterException($reflectionProperty->getName()
          . " type error, except {$type->getTypeName()}, actual "
          . json_encode($value)
          . " get"
          , HttpStatus::ARGS_ERROR);
      }

      if ($type->isUserDefinedClass()) {
        /**
         * @var $type Type\UserDefinedType
         */
        $userDefinedClass = (new ReflectionClass($type->getTypeName()))->getClassInstanceWithoutConstruct();
        $this->convert($value, $userDefinedClass);
        $reflectionProperty->setValue($object, $userDefinedClass);
        continue;
      }

      if ($type->isArray()) {
        $reflectionProperty->setValue($object, $this->convertArray($value, $type, $reflectionProperty->getName()));
        continue;
      }

      $reflectionProperty->setValue($object, $value);
    }
  }

  private function convertArray(array $array, Type $type, string $op): array {
    $results = [];
    /**
     * @var $type Type\ArrayType
     */
    $elementType = $type->getElementType();
    foreach ($array as $key => $value) {
      if (!$this->checkTypeIsRight($value, $elementType)) {
        throw new ConverterException(
          $op . "[$key] type error. except {$elementType->getTypeName()}, actual " . $value
          , HttpStatus::ARGS_ERROR);
      }

      if ($elementType->isArray()) {
        $results[] = $this->convertArray($value, $elementType, $op . "[$key]");
        continue;
      }

      if ($elementType->isUserDefinedClass()) {
        $userDefinedClass = (new ReflectionClass($type->getElementTypeName()))->getClassInstanceWithoutConstruct();
        $this->convert($value, $userDefinedClass);
        $results[] = $userDefinedClass;
        continue;
      }
    }
    return $results;
  }

  private function checkTypeIsRight($value, Type $type): bool {
    if (($type->isString() && is_string($value))
      || ($type->isInt() && is_int($value))
      || ($type->isFloat() && is_float($value))
      || ($type->isBool() && is_bool($value))
      || ($type->isNull() && is_null($value))
      || ($type->isUserDefinedClass() && is_object($value))
      || ($type->isArray() && is_array($value))
    ) {
      return true;
    }
    return false;
  }


  private function checkUsesIsRight($value, ?Uses $uses) {
    if ((is_null($value) && $uses->isRequired())) {
      return false;
    }
    return true;
  }
}