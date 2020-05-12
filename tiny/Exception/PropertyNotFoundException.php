<?php


namespace Tiny\Exception;

use Throwable;
use Tiny\API\HttpStatus;

class PropertyNotFoundException extends \Exception {

  public function __construct(string $className, string $propertyName, Throwable $previous = null) {
    $message = $className . '中不存在' . $propertyName . '成员属性';
    parent::__construct($message, HttpStatus::FAILED, $previous);
  }

}