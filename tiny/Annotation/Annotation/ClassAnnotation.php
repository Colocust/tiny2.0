<?php declare(strict_types=1);


namespace Tiny\Annotation;


use Tiny\Exception\ClassNotFoundException;

/**
 *
 *
 * 类的注解器
 *
 * 获取指定类信息
 *
 * 包括 常量、注释、成员属性等
 *
 *
 */
class ClassAnnotation {

  private $className_;
  private $instance_;


  public function __construct(string $className) {
    $this->className_ = $className;

    try {
      $this->instance_ = new \ReflectionClass($this->className_);
    } catch (\ReflectionException $e) {
      throw new ClassNotFoundException($this->className_);
    }

  }

  public function getInstance(): \ReflectionClass {
    return $this->instance_;
  }

  public function getClassInstanceWithoutConstruct(): object {
    return $this->instance_->newInstanceWithoutConstructor();
  }

  public function getConstants(): array {
    return $this->instance_->getConstants();
  }

  public function getParentName(): ?string {
    $parentClass = $this->instance_->getParentClass();
    if (!$parentClass) {
      return null;
    }
    return $parentClass->getName();
  }

  public function isSubClassOf(string $parentClassName): bool {
    return $this->instance_->isSubclassOf($parentClassName);
  }

  public function getProperties(): ?array {
    $properties = $this->instance_->getProperties();
    foreach ($properties as $property) {
      $propertyName[] = $property->getName();
    }
    if (!isset($propertyName)) {
      return null;
    }
    return $propertyName;
  }

  public function isAbstract(): bool {
    return $this->instance_->isAbstract();
  }

  public function isInterface(): bool {
    return $this->instance_->isInterface();
  }

  public function isTrait(): bool {
    return $this->instance_->isTrait();
  }
}