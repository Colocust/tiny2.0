<?php


namespace Tiny\Util;


use Tiny\Util\Type\ArrayType;
use Tiny\Util\Type\UserDefinedType;

class Validator {

  public function goCheck(object $values, object $object): bool {
    $annotation = $this->genAnnotationForValidate();
    $rules = $annotation->getObjectRules($object);

    foreach ($rules as $field => $rule) {
      if (!$this->checkIsRequired($rule, $values->{$field} ?? null)) {
        $this->stopValidateWithError("{$field} is required , but value is null");
      }

      $type = Type::createTypeFromRule($rule->type);

      if (!$this->checkTypeExists($type)) {
        $this->stopValidateWithError("{$field} Type is not exists");
      }

      //选填参数且该field没有值
      if (!isset($values->{$field}) || is_null($values->{$field})) {
        unset($values->{$field});
        continue;
      }
      $value = $values->{$field};

      if (!$this->checkTypeIsRight($type, $value)) {
        $this->stopValidateWithError($field
          . " type error, except {$type->getName()}, actual "
          . json_encode($value)
          . " get");
      }
    }

    return true;
  }

  private function checkIsRequired(object $rule, $value = null) {
    if (($rule->required) && !$value) {
      return false;
    }
    return true;
  }

  private function checkTypeExists(Type $type): bool {
    if ($type->getName() == "") {
      return false;
    }
    return true;
  }

  private function checkTypeIsRight(Type $type, $value): bool {
    if (($type->isString() && is_string($value))
      || ($type->isInt() && is_int($value))
      || ($type->isFloat() && (is_float($value) || is_int($value)))
      || ($type->isBool() && is_bool($value))
      || ($type->isNull() && is_null($value))
    ) {
      return true;
    }

    /**
     * @var $type UserDefinedType
     */
    if ($type->isUserDefinedClass()) {
      return $this->checkUserDefinedClass($type, $value);
    }

    /**
     * @var $type ArrayType
     */
    if ($type->isArray()) {
      return $this->checkArray($type->getRootType(), $value);
    }

    return false;
  }

  private function checkArray(Type $type, $values): bool {
    if (!is_array($values)) return false;
    foreach ($values as $value) {
      if (!$this->checkTypeIsRight($type, $value)) return false;
    }
    return true;
  }


  private function checkUserDefinedClass(UserDefinedType $type, $value): bool {
    if (!is_object($value)) {
      return false;
    }
    $namespace = $type->getUserDefinedTypeNamespace();
    if (!$namespace) {
      throw new \Exception("{$type->getName()} not found");
    }
    $clazz = $type->newUserDefinedTypeWithoutConstructor($namespace);
    return $this->goCheck($value, $clazz);
  }

  private function stopValidateWithError(string $errMsg = "参数验证失败"
    , \Throwable $previous = null) {
    throw new ValidateError($errMsg, $previous);
  }

  private function genAnnotationForValidate(): Annotation {
    return new Annotation();
  }
}