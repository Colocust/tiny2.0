<?php declare(strict_types=1);


namespace Tiny\Exception;

use Throwable;
use Tiny\API\HttpStatus;

class ClassNotFoundException extends \Exception {

  public function __construct(string $className, Throwable $previous = null) {
    $message = "$className NOT FOUND";
    parent::__construct($message, HttpStatus::FAILED, $previous);
  }

}