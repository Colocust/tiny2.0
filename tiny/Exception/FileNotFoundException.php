<?php


namespace Tiny\Exception;

use Throwable;
use Tiny\API\HttpStatus;

class FileNotFoundException extends \Exception {

  public function __construct($fileName, Throwable $previous = null) {
    $message = "$fileName NOT FOUND";
    parent::__construct($message, HttpStatus::FAILED, $previous);
  }

}