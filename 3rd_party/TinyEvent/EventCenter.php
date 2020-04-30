<?php


namespace Tiny\Event;


use Tiny\Logger;

class EventCenter {
  public static function New() {
    return new EventCenter();
  }

  public function postEvent(Event $event): bool {
    $res = true;
    $listenerClassSigns = ListenerProvider::getInstance()->getListener($event);
    foreach ($listenerClassSigns as $listenerClassSign) {
      Logger::getInstance()->info("postEvent: Event("
        . get_class($event)
        . ")--->Listener(" . $listenerClassSign . ")");

      $listener = Listener::New($listenerClassSign, $event);
      $res = $res && $listener->process();
    }
    return $res;
  }
}