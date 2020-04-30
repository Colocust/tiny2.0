<?php


namespace Tiny\Event;


use Tiny\Logger;

abstract class Listener {
  abstract protected function handle();

  public static function New(string $listenerSign, Event $event): Listener {
    return new $listenerSign($event);
  }

  public function process(): bool {
    try {
      $this->handle();
    } catch (\Exception $e) {
      Logger::getInstance()->error(get_class($this) . " error!", $e);

      $this->event_->handleError();
      return false;
    }

    Logger::getInstance()->info(get_class($this) . " success!");

    $this->event_->handleOver();
    return true;
  }

  public function __construct(Event $event) {
    $this->event_ = $event;
  }

  protected $event_;
}