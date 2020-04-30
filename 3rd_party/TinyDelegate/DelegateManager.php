<?php

namespace Tiny;

use Tiny\Util\Clazz;

class DelegateManager {

  public static function getDelegateClassName(Clazz $delegateType): ?string {
    $delegateMap = \DelegateMap::delegateMap;

    $name = $delegateMap[$delegateType->getName()];
    if ($name === null) {
      return null;
    }

    return $name;
  }
}