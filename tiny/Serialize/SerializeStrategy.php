<?php declare(strict_types=1);

namespace Tiny\Serialize;


interface SerializeStrategy {
  function encode(object $object): string;

  function decode(string $string): \stdClass;
}