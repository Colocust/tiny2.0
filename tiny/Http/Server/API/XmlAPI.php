<?php declare(strict_types=1);


namespace Tiny\Http;


use Tiny\Serialize\XmlSerializeStrategy;

abstract class XmlAPI extends API {
    public function __construct() {
        $this->setParseStrategy(new XmlSerializeStrategy());
    }
}