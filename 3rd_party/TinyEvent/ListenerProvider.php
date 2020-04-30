<?php


namespace Tiny\Event;


class ListenerProvider {
  private function __construct() {
  }

  private function __clone() {
  }

  private static $instance = null;

  public static function getInstance(): self {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getListener(Event $event): array {
    return $event->listeners();
  }
}