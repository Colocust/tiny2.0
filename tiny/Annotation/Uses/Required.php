<?php declare(strict_types=1);


namespace Tiny\Annotation\Uses;


use Tiny\Annotation\Uses;

class Required implements Uses {

  public function isRequired(): bool {
    return true;
  }

  public function isOptional(): bool {
    return false;
  }

  public function getName(): string {
    return 'Required';
  }
}