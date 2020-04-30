<?php

namespace Event;

use Listener\Test1Listener;
use Listener\Test2Listener;
use Tiny\Event\Event;
use Tiny\Logger;

class TestEvent implements Event {

  public function handleOver() {
    Logger::getInstance()->info('TestEvent handle over');
  }

  public function handleError() {
    Logger::getInstance()->info('TestEvent handle error');
  }

  public function listeners(): array {
    return [
      Test1Listener::class,
      Test2Listener::class
    ];
  }
}