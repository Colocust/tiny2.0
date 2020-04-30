<?php


namespace API;


abstract class SingleClientLoginAPI extends LoginAPI {
  protected function isSupportMultiClient(): bool {
    return false;
  }
}