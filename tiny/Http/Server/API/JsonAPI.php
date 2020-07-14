<?php declare(strict_types=1);


namespace Tiny\Http;


use Tiny\Serialize\JsonSerializeStrategy;

abstract class JsonAPI extends API {
  public function __construct() {
    $this->setParseStrategy(new JsonSerializeStrategy());
  }
}