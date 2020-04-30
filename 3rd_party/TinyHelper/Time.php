<?php


namespace Tiny;


class Time {
  public static function getCurrentMillSecond(): int {
    return (int)(microtime(true) * 1000);
  }

  public static function getCurrentMillSecondToString(): string {
    $millTime = self::getCurrentMillSecond();
    return date("Y-m-d H:i:s") . "," . $millTime % 1000;
  }
}