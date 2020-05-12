<?php declare(strict_types=1);


namespace Tiny\Exception;


use Throwable;
use Tiny\API\HttpStatus;

class ValidateException extends \Exception {
  public function __construct($message, int $code = HttpStatus::FAILED, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}