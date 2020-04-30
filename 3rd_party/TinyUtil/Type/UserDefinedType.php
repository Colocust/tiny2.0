<?php


namespace Tiny\Util\Type;


use Tiny\ClassMap;
use Tiny\Util\Type;

class UserDefinedType extends Type {
  public function isUserDefinedClass(): bool {
    return true;
  }

  /**
   * @param string $namespace
   * @return object
   * @throws \ReflectionException
   */
  public function newUserDefinedTypeWithoutConstructor(string $namespace): object {
    $clazz = new \ReflectionClass($namespace);
    return $clazz->newInstanceWithoutConstructor();
  }

  public function getUserDefinedTypeNamespace(): ?string {
    $classMap = ClassMap::classMap;
    foreach ($classMap as $className => $dir) {
      //使用自定义类时 一定要与使用此类的class 命名空间一致 用use的方式使用此类
      $dirs = explode("\\", $className);
      $userDefinedClassDirs = explode("\\", $this->getName());
      if ($dirs[count($dirs) - 1] == $userDefinedClassDirs[count($userDefinedClassDirs) - 1]) {
        return $className;
      }
    }
    return false;
  }
}