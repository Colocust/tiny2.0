<?php


namespace Tiny;


class ToFormat {
  public static function Array($obj): array {
    $object = json_decode(json_encode($obj), true);
    return array_filter($object, function ($v, $k) {
      return $v !== null;
    }, ARRAY_FILTER_USE_BOTH);
  }

  public static function Xml(array $array) {
    $xmlData = "<xml>";
    foreach ($array as $key => $value) {
      $xmlData .= "<" . $key . "><![CDATA[" . $value . "]]></" . $key . ">";
    }
    $xmlData = $xmlData . "</xml>";
    return $xmlData;
  }
}