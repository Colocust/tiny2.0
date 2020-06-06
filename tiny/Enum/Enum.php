<?php declare(strict_types=1);


namespace Tiny\Enum;


use Tiny\Annotation\Reflection\ReflectionClass;

class Enum {

  protected $value_;

  private static $constants = [];

  public function getValue() {
    return $this->value_;
  }

  public function __construct($value) {
    $class = get_class($this);

    $this->populateConstants();

    $temp = self::$constants[$class];

    if (!in_array($value, $temp, true)) {
      throw new \Error("$value is not in enum " . $class);
    }

    $this->value_ = $value;
  }


  private function populateConstants() {
    if (array_key_exists(static::class, self::$constants)) {
      return;
    }

    $instance = new ReflectionClass(static::class);
    $constants = $instance->getInstance()->getConstants();

    self::$constants[static::class] = $constants;
  }
}