<?php


namespace API;


abstract class MultiClientLoginAPI extends LoginAPI {
  protected function isSupportMultiClient(): bool {
    return true;
  }
}