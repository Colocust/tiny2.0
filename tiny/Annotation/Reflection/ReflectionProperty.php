<?php declare(strict_types=1);


namespace Tiny\Annotation\Reflection;


use Tiny\Annotation\Type;
use Tiny\Annotation\Uses;

/**
 *
 * 成员属性注解器
 *
 * 可获取指定类中成员属性的类型以及使用情况的信息
 *
 */
class ReflectionProperty {

  private $propertyDoc_ = null;
  private $instance_;
  private $className_;
  private $propertyName_;


  public function __construct(string $className, $propertyName) {
    $this->instance_ = new \ReflectionProperty($className, $propertyName);
    $this->propertyDoc_ = $this->instance_->getDocComment();
    $this->className_ = $className;
    $this->propertyName_ = $propertyName;
  }


  public function getType(): ?Type {
    if (!$this->propertyDoc_) {
      return null;
    }
    preg_match("/(@var)(.*)(\n)/U", $this->propertyDoc_, $matches);
    if (empty($matches)) {
      return null;
    }
    if (!isset($matches[2])) {
      return null;
    }

    $type = Type::createType($this->className_, trim($matches[2]));
    return $type;
  }


  public function getUses(): ?Uses {
    if (!$this->propertyDoc_) {
      return null;
    }
    preg_match("/(@uses)(.*)(\n)/U", $this->propertyDoc_, $matches);

    if (empty($matches)) {
      return null;
    }
    if (!isset($matches[2])) {
      return null;
    }
    $uses = trim($matches[2]);
    $classAnnotator = new ReflectionClass($uses);
    if (!$classAnnotator->isSubClassOf('\Tiny\Annotation\Uses')) {
      return null;
    }

    return new $uses;
  }

  public function getInstance(): \ReflectionProperty {
    return $this->instance_;
  }
}
