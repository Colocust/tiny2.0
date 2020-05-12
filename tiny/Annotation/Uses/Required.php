<?php declare(strict_types=1);


namespace Tiny\Annotation\Uses;


use Tiny\Annotation\Uses;

class Required implements Uses {

  function isRequired(): bool {
    return true;
  }

  function isOptional(): bool {
    return false;
  }
}