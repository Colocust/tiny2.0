<?php declare(strict_types=1);


namespace Tiny\Serialize;


class XmlSerializeStrategy implements SerializeStrategy {

  function encode(object $object): string {
    return self::toXml($object);
  }

  function decode(string $string): \stdClass {
    libxml_disable_entity_loader(true);
    return json_decode(json_encode(simplexml_load_string($string
      , 'SimpleXMLElement', LIBXML_NOCDATA)));
  }

  public static function toXml(object $object): string {
    $xml = "<xml>";
    foreach ($object as $key => $val) {
      if (is_numeric($val)) {
        $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
      } else {
        $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
      }
    }
    $xml .= "</xml>";
    return $xml;
  }
}