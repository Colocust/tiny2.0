<?php declare(strict_types=1);


namespace Tiny;


class Loader {
  public static function register() {
    spl_autoload_register('Tiny\\Loader::autoload', true, true);
  }

  public static function autoload(string $class) {
    if (self::load($class)) return;
  }

  private static function load(string $class): bool {
    include_once __ROOT__ . DIRECTORY_SEPARATOR . '__ClassLoader__.php';
    $classMap = __ClassLoader__::$classMap;
    $dir = @$classMap[$class];
    if (is_null($dir)) {
      return false;
    }
    include_once __ROOT__ . $dir;
    return true;
  }
}