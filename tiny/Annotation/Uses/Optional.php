<?php declare(strict_types=1);


namespace Tiny\Annotation\Uses;


use Tiny\Annotation\Uses;

class Optional implements Uses {

  function isRequired(): bool {
    return false;
  }

  function isOptional(): bool {
    return true;
  }

  function getName(): string {
    return 'Optional';
  }
}