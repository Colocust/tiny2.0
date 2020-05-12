<?php declare(strict_types=1);


namespace Tiny\Serialize;


class JsonSerializeStrategy implements SerializeStrategy {

  function encode(object $obj): string {
    return json_encode($obj);
  }

  function decode(string $string): \stdClass {
    return json_decode($string);
  }

  public static function toArray(object $obj): array {
    $object = json_decode(json_encode($obj), true);
    return array_filter($object, function ($v, $k) {
      return $v !== null;
    }, ARRAY_FILTER_USE_BOTH);
  }
}