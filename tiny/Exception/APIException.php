<?php declare(strict_types=1);


namespace Tiny\Exception;


use Throwable;
use Tiny\API\HttpStatus;

class APIException extends \Exception {
  public function __construct($message, Throwable $previous = null) {
    parent::__construct($message, HttpStatus::FAILED, $previous);
  }
}