<?php


namespace Tiny;


class Loader {
  public static function register() {
    spl_autoload_register('Tiny\\Loader::autoload', true, true);
  }

  private static $hasIncludeClassLoader = false;

  /**
   * @param string $class
   * @throws \Exception
   */
  public static function autoload(string $class) {
    if (self::load($class)) return;
  }

  private static function load(string $class): bool {
    $rootPath = dirname(dirname(__dir__));
    $classLoaderPath = $rootPath . DIRECTORY_SEPARATOR . '__ClassLoader__.php';
    if (!is_file($classLoaderPath)) {
      throw new \Exception('__ClassLoader__ not found');
    }

    if (!self::$hasIncludeClassLoader) {
      self::$hasIncludeClassLoader = true;
      require_once $classLoaderPath;
    }

    $allClasses = ClassMap::classMap;
    if (isset($allClasses[$class])) {
      require_once $rootPath . DIRECTORY_SEPARATOR . $allClasses[$class];
      return true;
    }
    return false;
  }
}