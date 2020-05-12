<?php declare(strict_types=1);


namespace Tiny\Annotation\Type;


use Tiny\Annotation\Type;

class UserDefinedType extends Type {

  public function isUserDefinedClass(): bool {
    return true;
  }
}